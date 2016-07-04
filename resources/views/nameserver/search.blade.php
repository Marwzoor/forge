@extends('layouts.page')

@section('title', 'Nameserver search')

@section('content')

<h1>Nameserver search</h1>

<p>Enter domain here and you will be presented with what company that hosts the nameserver for the domain.</p>
<p>If you know a nameserver domain and what company that stands behind it, please go to the <a href="{{ action('NameserverController@getSubmit') }}">submit</a> page and follow the instructions there.</p>

<form class="nameserver-search-form" method="POST" action="{{ action('NameserverController@postSearch') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<label for="domain">
			Domain to search
		</label>
		<input class="form-control" type="text" id="domain" name="domain" placeholder="Domain (example.com)">
	</div>
	<div class="form-group">
		<button class="btn btn-primary" type="submit">
			Search
		</button>
	</div>
</form>

<div class="nameserver-result" style="display: none;">
	<h2>Search results</h2>
	<div class="well">
		<div>
			<strong>Domain:</strong>
			<span class="nameserver-domain">
			</span>
		</div>
		<div>
			<strong>Company name:</strong>
			<span class="nameserver-company-name">
			</span>
		</div>
		<div>
			<strong>Company URL:</strong>
			<a class="nameserver-company-url" target="_BLANK">
			</a>
		</div>
	</div>
</div>

@stop