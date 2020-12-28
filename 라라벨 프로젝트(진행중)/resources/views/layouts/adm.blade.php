
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>

<title> @yield('title') | 보네르</title>
    @section('header_css_js')
        <link rel="stylesheet" href="{{ mix('/css/app.css')}}" type="text/css" />
        <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
    @show
</head>
<body>
<div class="manager_main_content">
@if(session()->has('flash_message'))
    <div class=""alert alert-info role="alert">
        {{session('flash_message')}}
    </div>
@endif
	<!-- left_menu -->
	<?php //include "./adm/layout/left_menu.php";?>
	@section('leftmenu_html')
	@include('leftmenu.adm')
	@show
	@yield('leftmenu_js')
	<div class="manager_rightmenu">
		<div class="main_content">
			<div class="main_title">
				<h2>@yield('sub_title')</h2>
			</div>
			@yield('content')
		</div>
	</div>
</div>
@yield('validate_js')
</body>
</html>
