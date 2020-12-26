<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserImageUploadRepositoryContract;

class UserImageUploadService
{
    /**
     * @var UserImageUploadRepositoryContract
     * 
     */
    protected $userImageUploadRepositoryContract;

    /**
     * @var UserImageUploadService constructor
     * 
     * @param UserImageUploadRepositoryContract $userImageUploadRepositoryContract
     * @return void
     */
    public function __construct(UserImageUploadRepositoryContract $userImageUploadRepositoryContract)
    {
        $this->userImageUploadRepositoryContract = $userImageUploadRepositoryContract;
    }

    /**
     * @param string $file
     * @return mixed
     */
    public function saveUpload(string $file)
    {
        return $this->userImageUploadRepositoryContract->saveUpload($file);
    } 
}
