<!DOCTYPE html>
<html lang="en">
    @include('layouts.admin.head')
    <body>
		<div id="main-wrapper">
			@include('layouts.admin.header')
			@section('sidebar')
				@include('layouts.admin.leftmenu')
			@show
			
			@yield('content')
			
		</div>
		@include('layouts.admin.footer')
    </body>
</html>