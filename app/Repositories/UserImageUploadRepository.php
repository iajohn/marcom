<?php

namespace App\Repositories;

use App\Models\UserUpload;
use App\Repositories\Contracts\UserImageUploadRepositoryContract;
use Illuminate\Support\Facades\Storage;

class UserImageUploadRepository implements UserImageUploadRepositoryContract
{
    /**
     * @param  string  $file
     * @return mixed
     */
    public function saveUpload($file)
    {
        try {
            $newImage = new UserUpload();
            $newImage->name = url(Storage::url($file));
            $newImage->user_id = auth()->user()->id;
            $newImage->save();

            return true;
        } catch (\Throwable $error) {
            return false;
        }
    }


}
