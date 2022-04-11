<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Support\Facades\File;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],            
        ])->validateWithBag('updateProfileInformation');


        if (array_key_exists('profile_img', $input)) {

            Validator::make($input, [
                'profile_img' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ])->validateWithBag('updateProfileInformation');

            if ($user -> profile_img)
                File::delete(public_path($user -> profile_img));

            $image_name = time().'.'.$input['profile_img']->getClientOriginalName();
            $input['profile_img']->move(public_path('img/users/profiles'), $image_name);

            $user->forceFill([
                'profile_img' => "img/users/profiles/" . $image_name
            ])->save();

        }

        if (array_key_exists('profile_img_removal', $input)) {
            File::delete(public_path($user -> profile_img));
            $user->forceFill([
                'profile_img' => null
            ])->save();
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
