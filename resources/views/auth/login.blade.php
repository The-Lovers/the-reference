@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ sec_asset('lib/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ sec_asset('lib/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ sec_asset('auth/login/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ sec_asset('auth/login/css/main.css') }}">
@endsection

@section('content')
    <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ sec_asset('auth/login/images/img-01.png') }}" alt="images">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
					@csrf
					<span class="login100-form-title">
                        <a href="{{ route('index') }}">
                            <img src="{{ sec_asset('images/logo.png') }}" alt="accueil" class="img-fluid">
                        </a>
						{{ __('login.login') }}
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Email or username is required">
						<input class="input100" type="text" name="email" placeholder="Email or username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                        <span class="error text-danger"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="{{ __('login.password') }}">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                        <span class="error text-danger"></span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
                            {{ __('login.submit') }}
						</button>
					</div>

					<div class="text-center p-t-12">
                        <a class="txt2" href="#">
							{{ __('login.username') }} / {{ __('login.password') }}
						</a>

						<span class="txt1">
							{{ __('login.forgot_password') }}
						</span>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="{{ route('index') }}">
							{{ __('login.title') }}
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js')
    <script src="{{ sec_asset('lib/bootstrap-5.3.8/js/popper.js') }}"></script>
    <script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
    <script src="{{ sec_asset('auth/login/js/main.js') }}"></script>
@endsection
