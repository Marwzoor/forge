<?php

namespace App\Http\Controllers;

use \Input, \ZipArchive, \Image;
use App\Models\ImageCompression;
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

		do {
			$hash = md5(uniqid(rand(), true));
		} while(!is_null(ImageCompression::where('hash', '=', $hash)->first()));

		$zip = new ZipArchive();

		if(!$zip->open($zipFile, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE)) {
			return response()->json([
				"success"	=> false,
				"message"	=> "An error occurred. Files couldn't be compressed.",
			], 500);
		}

		foreach($images as $image) {
			$img = Image::make($image)->resize($maxWidth, $maxHeight, function ($constraint) {
	            $constraint->aspectRatio();
	            $constraint->upsize();
	        });

	        $data = $img->encode($image->getMimeType(), $quality);

	        $zip->addFromString($image->getClientOriginalName(), $data);
		}

		$zip->close();

		$imageCompression = new ImageCompression();
		$imageCompression->file_uri = $zipFile;
		$imageCompression->hash = $hash;
		$imageCompression->client_ip = request()->ip();
		$imageCompression->save();

		return response()->json([
			"downloadUrl"	=> action('ImageCompressController@downloadCompressedImages', ['hash' => $hash]),
			"message"		=> "Compression completed. Downloading...",
			"success"		=> true,
		], 200);
	}

	public function downloadCompressedImages($hash) {
		$imageCompression = ImageCompression::where('hash', '=', $hash)
			->where('client_ip', '=', request()->ip())
			->first();

		if(is_null($imageCompression)) {
			return response("Couldn't find compressed file.", 404);
		}

		$fileName = "image-compression-" . date("Y-m-d", strtotime($imageCompression->created_at)) . ".zip";

		return response()->download($imageCompression->file_uri, $fileName);
	}
}
