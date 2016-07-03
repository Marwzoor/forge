<?php

namespace App\Http\Controllers;

use \Input, \ZipArchive, \Image;
use Illuminate\Http\Request;

use App\Http\Requests;

class ImageCompressController extends Controller
{
	public function index() {
		return view('image-compressor');
	}

	public function compressImages() {
		$maxWidth = Input::get('max_image_width', 2000);
		$maxHeight = Input::get('max_image_height', 2000);
		$quality = Input::get('image_quality', 90);

		$images = Input::file('images');

		$count = 1;

		do {
			$zipFile = storage_path() . '/app/image-compressions/' . microtime(true) . '-' . $count .'.zip';
			++$count;
		} while(file_exists($zipFile));

		$zip = new ZipArchive();

		if(!$zip->open($zipFile, ZipArchive::OVERWRITE)) {
			return redirect()->action('ImageCompressController@index')->with('error', 'Couldn\'t open ZIP-archive!');
		}

		foreach($images as $image) {
			// dd($image);

			$img = Image::make($image)->resize($maxWidth, $maxHeight, function ($constraint) {
	            $constraint->aspectRatio();
	            $constraint->upsize();
	        });

	        $data = $img->encode($image->getMimeType(), $quality);

	        $zip->addFromString($image->getClientOriginalName(), $data);
		}

		$zip->close();

		$fileName = "compressed-images-" . date( "Y-m-d" ) . ".zip";

		return response()->download($zipFile, $fileName);
	}
}
