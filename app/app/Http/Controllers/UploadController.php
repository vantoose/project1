<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpload;
use App\Http\Requests\UpdateUpload;
use App\Models\Upload;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->authorizeResource(Upload::class, 'upload');
	}

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$user = $request->user();
		//$uploads = $user->uploads()->ordered()->get();
		$trashed = $user->uploads()->onlyTrashed();
		$uploadsWithTrashed = $user->uploads()
		->union($trashed)->ordered()->paginate(20);
		return view('uploads.index')->withUploads($uploadsWithTrashed);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$user = $request->user();
		$validated = $request->validated();
		$validated['options'] = null;
		$validated['user_id'] = $user->id;
		try {
			$file = $request->file('upload_file');
			if ($file->isValid()) {
				$upload = Upload::upload_file($file, $validated, $dir = 'user' . $user->id);
			}
			if ($request->wantsJson()) return $upload;
			return back()->withStatus('Success.');
		} catch (\Exception $e) {
			$errors = $e->getMessage();
			return back()->withErrors($errors);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
		return response()->file($upload->absolutePath);
    }

	/**
	 * Download the specified resource.
	 *
	 * @param  \App\Models\Upload  $upload
	 * @return \Illuminate\Http\Response
	 */
	public function download(Upload $upload)
	{
        $this->authorize('download', $upload);
		return $upload->download();
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
		try {
            $upload->delete();
            return back()->withStatus('Success.');
		} catch (\Exception $e) {
            $errors = $e->getMessage();
            return back()->withErrors($errors);
		}
    }
}
