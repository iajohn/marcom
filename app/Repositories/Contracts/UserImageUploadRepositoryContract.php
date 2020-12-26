<?php

namespace App\Repositories\Contracts;

interface UserImageUploadRepositoryContract
{
    /**
     * @param string $file
     * 
     * @return mixed
     * 
     */
    public function saveUpload(string $file);
}