@extends('layouts.page')

@section('content')

<h1>Image compressing</h1>

<p>Upload multiple images here and download a ZIP-file containing the image files resized to your preferred size.</p>

<form class="image-compress-form" target="_BLANK" method="POST" action="{{ action('ImageCompressController@compressImages') }}" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<div class="row">
			<div class="col-xs-2">
				<label for="max_image_width">
					Max width for images
				</label>
				<input class="form-control" type="number" id="max_image_width" name="max_image_width" placeholder="Max width (px)" />
			</div>
			<div class="col-xs-2">
				<label for="max_image_height">
					Max height for images
				</label>
				<input class="form-control" type="number" id="max_image_width" name="max_image_height" placeholder="Max height (px)" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-xs-4">
				<label for="image_quality">
					Quality of images
				</label>
				<input min="0" max="100" step="1" class="form-control" type="number" id="image_quality" name="image_quality" placeholder="Image quality (0-100)" />
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-xs-4">
				<label for="selected_images">
					Images to be compressed
				</label>
				<input class="form-control" id="selected_images" type="file" name="images[]" accept="image/*" multiple="true">
			</div>
		</div>
	</div>
	<div class="form-group">
		<button class="btn btn-primary" type="submit">
			Compress and download
		</button>
	</div>
	<div class="form-group">
		<div class="progress" style="display: none;">
		 	<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		    	<span class="sr-only"><span class="progress-percentage">0%</span> Complete</span>
		 	</div>
		</div>
	</div>
</form>

@stop