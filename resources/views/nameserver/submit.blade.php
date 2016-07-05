@extends('layouts.page')

@section('title', 'Nameserver submit')

@section('content')

<h1>Submit nameserver information</h1>

<p>Submit information here to update the database of different owners of nameservers.</p>

<form class="nameserver-submit-form" method="POST" action="{{ action('NameserverController@postSubmit') }}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<label for="hostname">
			Hostname
		</label>
		<input class="form-control" value="{{ Input::get('hostname', '') }}" type="text" id="hostname" name="hostname" placeholder="Hostname (ns1.example.com)">
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-xs-6">
				<label for="company_name">
					Company name
				</label>
				<input class="form-control" value="{{ Input::get('company_name', '') }}" type="text" id="company_name" name="company_name" placeholder="Company name">
			</div>
			<div class="col-xs-6">
				<label for="company_url">
					Company url
				</label>
				<input class="form-control" value="{{ Input::get('company_url', '') }}" type="url" id="company_url" name="company_url" placeholder="Company url">
			</div>
		</div>
	</div>
	<div class="form-group">
		<button class="btn btn-primary" type="submit">
			Submit
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