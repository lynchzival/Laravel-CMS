<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function plan(){
        $key = env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($key);
        $plansraw = $stripe->plans->all();
        $plans = $plansraw->data;
        
        foreach($plans as $plan) {
            $prod = $stripe->products->retrieve(
                $plan->product,[]
            );
            $plan->product = $prod;
        }

        return view('stripe.index', [
            'plans' => $plans
        ]);
    }

    public function index(){
        $user = User::find(auth() -> user() -> id);

        return view("stripe.payment", [
            'intent' => $user -> createSetupIntent()
        ]);
    }

    public function store(Request $request){
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
                    
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        $plan = $request->input('plan');

        try {
            $user->newSubscription('default', $plan)->create($paymentMethod, [
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }

        return redirect()->route('profile.subscription');

    }

    public function destroy(){
        Auth::user()->subscription('default')->cancel();

        return redirect()->route('profile.subscription');
    }

    public function resume(){
        Auth::user()->subscription('default')->resume();

        return redirect()->route('profile.subscription');
    }
}
