@extends('layouts.app')

@section('content')
<div class="iw-login-area">
	<div class="container-fluid">
		<div class="iw-login-left-area">
			<div class="iw-login-left">
				<div class="iw-logo-area">
					<a href="{{url('/')}}"><img src="{{asset('assets/img/munshi-logo(220px).png')}}"/></a>
				</div>
				<div class="iw-login-title">
					<h4>Welcome to Munshi</h4>
					<p>Login into your account</p>
				</div>
			</div>
		</div>
		<div class="iw-login-form">
			<div class="row justify-content-center align-items-center h-100">
				<div class="col-lg-4 col-md-6">
					<div class="card">

						<div class="card-body">
							<div class="iw-login-form-title">
								<strong>Login</strong>
							</div>
							<form method="POST" action="{{ route('login') }}">
								@csrf

								<div class="form-group">
									<label for="email" class="col-form-label label">{{ __('E-Mail Address') }}</label>
									<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

									@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>

								<div class="form-group">
									<label for="password" class="col-form-label  label">{{ __('Password') }}</label>
									<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

									@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

												<label class="form-check-label" for="remember">
													{{ __('Remember Me') }}
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="text-right">
											@if (Route::has('password.request'))
											<a class="" href="{{ route('password.request') }}" style="color:#555">
												{{ __('Forgot Your Password?') }}
											</a>
											@endif
										</div>
									</div>
								</div>
								<button type="submit" class="btn iw-submit-btn">
									{{ __('Login') }}
								</button>

								<p class="text-center mt-5">Don't have an account? <a class="iw-signup" href="{{ route('register') }}">Sign Up</a></p>


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
    .iw-login-area {
    background: #fff;
    margin:-1.5rem 0
	}
    .iw-login-form .card {
    background: #f7f8fc;
}
	.iw-login-form-title {
    font-size: 30px;
    margin-bottom: 30px;
}
.iw-login-left-area {
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
.iw-login-left {
    width: 75%;
    text-align: center;
}

.iw-login-left .iw-login-title h4 {
font-weight: 600;
font-size: 30px;
color:#fff
}

.iw-login-left .iw-login-title p {
font-size: 16px;
color:#fff
}

.iw-login-left .iw-logo-area {
background: #fff;
width: 250px;
margin: auto;
padding: 20px 0;
border-radius: 3px;
box-shadow: 0 0 10px rgb(0 0 0 / 25%);
margin-bottom: 20px;
}

.iw-login-left .iw-logo-area img {
max-width: 100%;
}
.iw-login-area .iw-submit-btn {
background: #fc0102;
width: 100%;
color: #fff;
font-size: 16px;
font-weight: 600;
padding: 8px 0;
}
.iw-login-area .iw-submit-btn:hover{
background:rgb(255 0 0 / 80%);
color:#fff
}
.iw-login-area .iw-submit-btn:focus{
outline:0;
box-shadow: none
}
a.iw-signup {
color: #fc0102;
font-weight: bold;
text-decoration: none;
}
.iw-login-form .label {
    font-weight: 600;
}

@media (max-width:991px){
    .iw-login-left-area{
        display:none
    }
    .iw-login-area {
    background: #0c2097;
}
}
</style>
