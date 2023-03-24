@extends('layouts.app')
@section('content')
    <!-- Wrapper Starts -->
    <div class="wrapper">
        <div class="container user-auth" style="padding:20px;">
			<div class="row">
				<div class="col-sm-5 col-sm-offset-4 col-md-offset-4 col-lg-offset-4 col-md-5 col-lg-5">
					<!-- Logo Starts -->
					<div class="text-center mb-4">
		   
					@if(isset($settings->logo))	
					<a href="{{url('/')}}" style="text-align:center; width:100%; color:#555;">
						
						<img id="logo" class="img-responsive" src="{{ url('images/b4u-logo.png')}}" alt="logo" style="margin-left: auto; margin-right: auto;">
					</a>
					@else
						<a style="text-align:center; width:100%;" href="{{ url('/') }}">
							<img src="{{ url('images/b4u-logo.png') }}" style="margin-left: auto; margin-right: auto;">
						</a>
					@endif
					</div>
					<!-- Logo Ends -->
					@if(Session::has('message'))
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<i class="fa fa-warning"></i> {{ Session::get('message') }}
							</div>
						</div>
					</div>
					@endif
					@if(isset($rmessage))
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<i class="fa fa-ok"></i> {{ $rmessage }}
							</div>
						</div>
					</div>
					@endif


					@if (session('warning'))
						<div class="alert alert-warning">
							{{ session('warning') }}
						</div>
					@endif
					
					<div class="form-container">
						<div>
							<!-- Section Title Starts -->
							<div class="row text-center">
								<h2 class="title-head" style="font-size:1.5em; color:#555;">Resend Activations Code</h2>
							</div>
							<!-- Section Title Ends -->
							<!-- Form Starts -->
							<div class="card-content">
							@if (session('status'))
								<div class="alert alert-success">
									{{ session('status') }}
								</div>
							@endif
						
								<form class="resend-code-your-account" method="POST" action="{{ route('post_resendsms') }}">

									{{ csrf_field() }}

									<div class="field is-horizontal">
										<div class="field-label">
											<label for="method_sms" class="label">Resend Varification Code:</label>
										</div>

										<div class="field-body">
											<div class="field">
												<p class="control">
													<input style="background:transparent; color:#555;" class="form-control" id="email" type="email" name="email" placeholder="ENTER Email Id Attached To Your Account"
														   value="{{ old('email') }}" required autofocus>
												</p>

												@if ($errors->has('email'))
													<p class="help is-danger">
														{{ $errors->first('email') }}
													</p>
												@endif
											</div>
										
											
										</div>
									</div>
									<button class="btn btn-lg btn-primary btn-block" name="button" type="submit">Resend Activitions Code</button>

								</form>
								<div class="form-group">
									<p class="text-center">Have an active account?  <a href="{{route('login')}}">Login Now</a></p>
								</div>
								<div class="form-group">
									<p class="text-center">Don't have an account?  <a href="{{route('register')}}">Register Now</a></p>
								</div>
								<!-- Form Ends -->
							</div>
						</div>
						<!-- Copyright Text Starts -->
						<p class="text-center copyright-text">Copyright © {{date('Y')}} @if(isset($settings->site_name)){{$settings->site_name}} @else B4U Trades @endif All Rights Reserved</p>
						<!-- Copyright Text Ends -->
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- Wrapper Ends -->

@endsection