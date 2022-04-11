@extends('main.index', ['title' => 'Edit', 'favicon' => asset('img/form-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/form.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background-color: #ecf0f1;">
        
        <section class="ftco-section">
            <div class="container">

                <div class="text-center">
                    <h1 class="text-uppercase my-5 text-black">Edit</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4 text-black my-5">
                        <form action="{{ route("category.update", $category -> slug) }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ $category -> name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input type=text" class="form-control" name="description" placeholder="Enter description"
                                value="{{ $category -> description }}">
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </header>
@endsection