@extends('layouts.app')

@section('content')
<div class="iw-register-area">
<div class="container-fluid">
    <div class="iw-register-left-area">
        <div class="iw-register-left">
            <div class="iw-logo-area">
                <a href="{{url('/')}}"><img src="{{asset('assets/img/munshi-logo(220px).png')}}"/></a>
            </div>
            <div class="iw-register-title">
                <h4>Welcome to Munshi</h4>
                <p>Register your account</p>
            </div>
        </div>
    </div>
    <div class="iw-register-form">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-lg-4 col-md-6">
            <div class="card">
                {{-- <div class="card-header">{{ __('Register') }}</div> --}}

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        <div class="iw-register-form-title">
                            <strong>Register</strong>
                        </div>
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label label">{{ __('Name') }}</label>

                            <div class="">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label label">{{ __('E-Mail Address') }}</label>

                            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label label">{{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class=" col-form-label label">{{ __('Confirm Password') }}</label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn iw-submit-btn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <p class="text-center mt-1">Already have an account? <a class="iw-signup" href="{{ route('login') }}">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
@endsection
<style>
     .iw-register-area {
    background: #fff;
    margin:-1.5rem 0
	}
    .iw-register-form .card {
    background: #f7f8fc;
}
	.iw-register-form-title {
    font-size: 30px;
    margin-bottom: 30px;
}
.iw-register-left-area {
position: absolute;
width: 45%;
left: 0;
top: 0;
bottom: 0;
display: flex;
align-items: center;
justify-content: flex-start;
background:url(./assets/img/login-bg.png);
background-position: center;
background-repeat: no-repeat;
background-size:cover
}
.iw-register-left {
    width: 75%;
    text-align: center;
}

.iw-register-left .iw-register-title h4 {
font-weight: 600;
font-size: 30px;
color:#fff
}

.iw-register-left .iw-register-title p {
font-size: 16px;
color:#fff
}

.iw-register-left .iw-logo-area {
background: #fff;
width: 250px;
margin: auto;
padding: 20px 0;
border-radius: 3px;
box-shadow: 0 0 10px rgb(0 0 0 / 25%);
margin-bottom: 20px;
}

.iw-register-left .iw-logo-area img {
max-width: 100%;
}
.iw-register-area .iw-submit-btn {
background: #fc0102;
width: 100%;
color: #fff;
font-size: 16px;
font-weight: 600;
padding: 8px 0;
}
.iw-register-area .iw-submit-btn:hover{
background:rgb(255 0 0 / 80%);
color:#fff
}
.iw-register-area .iw-submit-btn:focus{
outline:0;
box-shadow: none
}
a.iw-signup {
color: #fc0102;
font-weight: bold;
text-decoration: none;
}
.iw-register-form .label {
    font-weight: 600;
}

@media (max-width:991px){
    .iw-register-left-area{
        display:none
    }
    .iw-register-area {
    background: #0c2097;
}
}
</style>
