@extends('main.index', ['title' => 'Edit User', 'favicon' => asset('img/user-black.svg')])

@section('navbrand')
    <img src="{{ asset('img/user.svg') }}" width="30" height="30" alt="">
@endsection

@section('content')
    <header class="py-5 bg-image-full" style="background: #ecf0f1;">

        <div class="container-fluid py-5">

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 text-black mb-5">

                    <div class="text-center">
                        <img class="img-fluid rounded-circle mb-4 w-25" 
                        src="{{ asset('img/user-black.svg') }}" 
                        alt="..." />
                        <h1 class="text-uppercase my-5 text-black">Edit User</h1>
                    </div>

                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name"
                            value="{{ $user -> name }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" class="form-control" placeholder="Enter email" name="email"
                            value="{{ $user -> email }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>Roles</label>
                            <select class="form-select" name="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                    @if ($user->role_id == $role->id)
                                        selected
                                    @endif
                                    >{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $message)
                                        <li><small class="text-uppercase">{{ $message }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 mt-3 text-uppercase">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </header>
@endsection