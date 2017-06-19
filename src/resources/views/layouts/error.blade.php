<html>
	<head>
		<title>{{ config('app.name') }} Error @yield('type')</title>

		<link rel = "icon" href = "/images/favicon.ico"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
		<link rel = "stylesheet" type = "text/css" href = "{{ mix("css/error.css") }}"/>
	</head>

	<body>
		<div class="container">

		@yield('content')

		</div>
	</body>
</html>
