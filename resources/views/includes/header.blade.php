<nav class="main-navigation navbar navbar-inverse">
	<ul class="nav navbar-nav">
		<li class="{{ Request::is('/') ? 'active' : '' }}">
			<a href="{{ url('/') }}">Home</a>
		</li>
		<li class="{{ Request::is('image-compressor') ? 'active' : '' }}">
			<a href="{{ action('ImageCompressController@index') }}">Image Compressing</a>
		</li>
	</ul>
</nav>