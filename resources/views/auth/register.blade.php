@extends('layouts.app')
<!-- Phone Input CSS-->
<link rel="stylesheet" href="{{ asset('assets/flag_phone_input/css/intlTelInput.css')}}">
	<!--<link rel="stylesheet" href="{{ asset('home/flag_phone_input/css/demo.css')}}">-->
    <!-- Phone Input JS-->
<script src="{{ asset('assets/flag_phone_input/js/intlTelInput.js')}}"></script> 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Register With Email/Phone') }}</label>

                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" id="emailid" name="identity" checked>Email
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" id="phoneid" name="identity">Phone
                                </label>
                                <!--<input type="hidden" name="name" value="">
                                <input type="hidden" name="password" value="" >-->
                            </div>
                        </div>
                        

                        <div id="email-div" class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="phone-div" class="form-group row" style="display: none;">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone No') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus>
                                <span id="valid-msg" class="hide">✓ Valid</span>
                                <span id="error-msg" class="hide"></span>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>-->

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("phone-div").hide();
    $('#email').prop('required', 'required');
    $("#phone").val("");
});


$(function() {
   $("input[name='identity']").click(function() {
      // alert("Clicked");
     if ($("#emailid").is(":checked")) {
        $("#email-div").show();
       $("#phone-div").hide();
       $("#email").attr("required", "true");
       $('#phone').removeAttr('required');
       $("#phone").val("");
     } else {
       $("#email-div").hide();
       $("#phone-div").show();
       $("#phone").attr("required", "true");
       $('#email').removeAttr('required');
       $("#email").val("");
     }
   });
 });


 var input = document.querySelector("#phone"),
 errorMsg = document.querySelector("#error-msg"),
  validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    window.intlTelInput(input, {
		nationalMode: false,
		autoHideDialCode: true,
      // autoPlaceholder: "off",
		autoPlaceholder: "polite",
		formatOnDisplay: true,
		placeholderNumberType: "MOBILE",
        preferredCountries: ['us', 'pk', 'my', 'gb'],
		//separateDialCode: true,
		// allowDropdown: false,
		// dropdownContainer: document.body,
		// excludeCountries: ["us"],
		
		//input.val("fgg");
		
		//geoIpLookup: function(callback) {
		//$.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
		//var countryCode = (resp && resp.country) ? resp.country : "";
		//	callback(countryCode);
        //});
		//},
		// hiddenInput: "full_number",
		// initialCountry: "auto",
		// localizedCountries: { 'de': 'Deutschland' },
		// onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
		utilsScript: "{{ asset('assets/flag_phone_input/js/utils.js')}}?1590403638580",
    });  

    var reset = function() {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      validMsg.classList.remove("hide");
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
</script>
@endsection
