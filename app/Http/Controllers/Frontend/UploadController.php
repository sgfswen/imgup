<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;



class UploadController extends Controller {

	public function upload(){
		echo "here";
		if(Input::hasFile('file')){
			echo "uploaded";
			//echo 'Uploaded';
			//$file = Input::file('file');
			//$file->move('uploads', $file->getClientOriginalName());
			//echo '';
		}

	}
}
