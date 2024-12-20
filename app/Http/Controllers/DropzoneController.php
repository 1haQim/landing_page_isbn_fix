<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DropzoneController extends Controller
{
  public function storeMediaOne(Request $request)
  {
     
      $path = public_path('img_tmp_upload');
      $file = $request->file('file');
      $arrayRespones = [];
      $name = uniqid() . '_' . trim($file->getClientOriginalName());
      $file->move($path, $name);
      array_push($arrayRespones, ['name' => $name, 'original_name' => $file->getClientOriginalName()]);
      return response()->json($arrayRespones);
  }

  public function deleteMedia(Request $request)
  {
    $filename = public_path('img_tmp_upload/'. $request->input('filename')); // e.g., 'uploads/images/myfile.jpg'

    if (File::exists($filename)) {
        File::delete($filename);
        return response()->json(['success' => 'File deleted successfully']);
    }
    return response()->json(['error' => 'File not found'], 404);
  }
}
