<nav class="main-navigation navbar navbar-inverse">
	<ul class="nav navbar-nav">
		<li class="{{ Request::is('/') ? 'active' : '' }}">
			<a href="{{ url('/') }}">Home</a>
		</li>
		<li class="{{ Request::is('image-compressor') ? 'active' : '' }}">
			<a href="{{ action('ImageCompressController@getIndex') }}">Image Compressing</a>
		</li>
		<li role="presentation" class="dropdown">
		    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
		      Nameserver <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu">
		      	<li class="{{ Request::is('nameserver/search') ? 'active' : '' }}">
		      		<a href="{{ action('NameserverController@getSearch') }}">
		      			Search
		      		</a>
		      	</li>
		      	<li class="{{ Request::is('nameserver/submit') ? 'active' : '' }}">
		      		<a href="{{ action('NameserverController@getSubmit') }}">
		      			Submit
		      		</a>
		      	</li>
		    </ul>
		</li>
	</ul>
</nav>