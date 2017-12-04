<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
use App\Models\Activity;
use Storage;
use Image;
use DB;

trait GlobalTrait
{
    public function saveActivity(Request $request, $activity)
    {
        $activity = Activity::create([
          'user_id' => Auth::id(),
          'ip'=> $request->ip(),
          'browser' => $request->header('User-Agent'),
          'activity' => $activity
        ]);
    }

    public function deleteMedia($model)
    {
        if ($model->medias && count($model->medias) > 0) {
            foreach ($model->medias as $media) {
                $this->deletePhotoIfExists($media->folder, $media->filename);
                $media->delete();
            }
        }
    }

    public function deletePhotoIfExists($path, $filename)
    {
        if (Storage::disk('local')->exists($path.$filename)) {
            Storage::delete($path.$filename);
        }
    }

    public function storeGetCache($model, $keyName, $key)
    {
        $cacheName = '_'.$model.'_'.$keyName.'_'.$key;
        $data = Cache::remember($cacheName, 60, function () use ($model, $keyName, $key) {
            return $model::where($keyName, $key)->first();
        });
        return $data;
    }

    public function deleteCache($modelName)
    {
        $cache = DB::table('cache')->where('key', 'LIKE', "%$modelName%")->delete();
    }

    public function checkModel($model)
    {
        if (count($model) == 0) {
            return response()->json([
              'msg' => 'Data not found'
            ], 422);
        }
    }
}
