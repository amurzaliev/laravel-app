@extends('layout')

@section('content')
    <div class="container">
        <h1 class="text-center m-4">Login</h1>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form method="POST" action="{{ route('security_do_login') }}">
                    {{ csrf_field() }}
                    @if ($errors->has('login_failed'))
                        <span class="text-danger">{{ $errors->first('login_failed') }}</span>
                    @endif
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{Request::old('email')}}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-success btn-submit">Sign in</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
