<!DOCTYPE html>
<html>
	<head>
		<title>Martin's App - @yield('title')</title>
		@include('includes.head')
	</head>
	<body>
		<div class="page-container container">
			<header>
			@include('includes.header')
			</header>
			<main class="bg-default">
			@yield('content')
			</main>
			<footer>
			@include('includes.footer')
			</footer>
		</div>
	</body>
</html>