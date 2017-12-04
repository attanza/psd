<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UploadImageTrait;
use App\Models\Media;
use Image;
use Storage;

class MediaController extends Controller
{
    use UploadImageTrait;

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|max:5000',
            'id' => 'required|integer',
            'model' => 'required|string|max:25'
        ]);
        $file = $request->file('file');
        $mediable_id = $request->input('id');
        $mediable_type = $this->getModelName($request->input('model'));

        $dbModel = $mediable_type::find($mediable_id);

        $folder = 'app/public/'.$request->input('model').'/';
        $mainFileName = str_slug($dbModel->name).'-'.time().'.'.$file->getClientOriginalExtension();

        if (!file_exists(storage_path($folder))) {
            mkdir(storage_path($folder), 0755, true);
        }
        $media = Media::where('mediable_id', $mediable_id)
            ->where('mediable_type', $mediable_type)->first();
        if (count($media) > 0) {
            $this->deletePhotoIfExists($media->folder, $media->filename);
        }

        Image::make($file)->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($folder).$mainFileName);

        $this->saveMedia($mediable_id, $mediable_type, $folder, $mainFileName, $file);
        $dbModel = $mediable_type::find($mediable_id);
        return $this->getResource($request->input('model'), $dbModel);
    }
}
