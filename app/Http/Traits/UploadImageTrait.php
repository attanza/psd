<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Resources\Market\MarketR;
use App\Http\Resources\Product\ProductR;
use App\Models\Media;
use Image;
use Storage;

trait UploadImageTrait
{
    public function getModelName($input)
    {
        switch ($input) {
            case 'market':
                return 'App\Models\Market';
            break;
            case 'product':
                return 'App\Models\Product';
            break;

            default:
                return 'App\Models\Building';
            break;
        }
    }

    public function getResource($input, $data)
    {
        switch ($input) {
            case 'market':
                return new MarketR($data);
            break;

            case 'product':
                return new ProductR($data);
            break;

            default:
                return 'MarketR';
                break;
        }
    }

    public function deletePhotoIfExists($path, $filename)
    {
        if (Storage::disk('local')->exists($path.$filename)) {
            Storage::delete($path.$filename);
        }
    }
    public function deleteMedia($db, $model)
    {
        $media = Media::where('mediable_id', $db->id)->where('mediable_type', $model)->first();
        if (count($media) > 0) {
            $this->deletePhotoIfExists($media->folder, $media->filename);
            $media->delete();
        }
    }

    public function saveMedia($id, $model, $folder, $filename, $file)
    {
        $publicFolder = explode('/', $folder, 2)[1];
        $size = Storage::size($publicFolder.$filename);
        $mime = Storage::mimeType($publicFolder.$filename);
        $ext = pathinfo(storage_path().$publicFolder.$filename, PATHINFO_EXTENSION);
        $data = [
          'mediable_id' => $id,
          'mediable_type' => $model,
          'folder' => $publicFolder,
          'filename' => $filename,
          'extension' => $ext,
          'mime' => $mime,
          'size' => $size,
          'caption' => $filename
        ];

        $media = Media::where('mediable_id', $id)->where('mediable_type', $model)->first();
        if (!$media) {
            $media = Media::create($data);
        } else {
            $media->update($data);
        }

        $this->savePhotoAttribute($model, $id, $publicFolder, $filename);
        return $media;
    }

    private function savePhotoAttribute($model, $id, $publicFolder, $filename)
    {
        $models = ['App\Models\Market', 'App\User'];
        if (in_array($model, $models)) {
            $dataToUpdate = $model::find($id);
            if (count($dataToUpdate) == 0) {
                \Log::info('Data for update photo not found');
                return '';
            }
            $dataToUpdate->photo = $publicFolder.$filename;
            $dataToUpdate->save();
        }
    }
}
