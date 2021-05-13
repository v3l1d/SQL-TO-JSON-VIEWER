<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload(){
        return view('fileUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function fileUploadPost(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt,sql'
        ]);

        $filename = $request->file->getClientOriginalName();
        $request->file->storeAs('uploads', $filename);
            return redirect("/visualize");
}

  public function conversation(){
    return view('conversation');
  }

}
