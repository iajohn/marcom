<?php

namespace App\Http\Controllers\Users;

use App\Models\UserFile;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\UserImageUploadService;
use App\Http\Requests\Users\UserImageUploadRequest as FileUploadRequest;
use App\Repositories\Contracts\UserImageUploadRepositoryContract;

class UserFileController extends Controller
{
    /**
     * @var ResponseHelper
     * 
     */
    protected $response;

    /**
     * @var UserImageUploadService
     * 
     */
    protected $userImageUploadService;

    /**
     * @var UserImageUploadRepositoryContract
     * 
     */
    protected $userImageUploadRepositoryContract;

    /**
     * @var UserImageController constructor
     * 
     * @param ResponseHelper $response     * 
     * @param UserImageUploadRepositoryContract $userImageUploadRepositoryContract
     * @return void
     */
    public function __construct(
        ResponseHelper $response,
        UserImageUploadService $userImageUploadService,
        UserImageUploadRepositoryContract $userImageUploadRepositoryContract
    )
    {
        $this->response = $response;
        $this->userImageUploadService = $userImageUploadService;
        $this->userImageUploadRepositoryContract = $userImageUploadRepositoryContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(FileUploadRequest $request)
    {
        $file = $request->file->storeAs(
            'public/users/' . auth()->user()->id . '/images/' , $request->file->getClientOriginalName()
        );
        
        $this->userImageUploadService->saveUpload($file);

        return $this->response->successResponse(true, 'Image Uploaded Successfully', null, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserImage   $userImage
     * @return \Illuminate\Http\Response
     */
    public function show(UserFile $userImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserImage $userImage
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFile $userImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserImage   $userImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFile $userImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserImage $userImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFile $userImage)
    {
        //
    }
}
