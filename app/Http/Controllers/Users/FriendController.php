<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\UserService;

class FriendController extends Controller
{
    /**
     * @var ResponseHelper
     * 
     */
    protected $response;

    /**
     * @var UserService
     * 
     */
    protected $userService;

    /**
     * @var FriendController constructor
     * 
     * @param ResponseHelper $response
     * @return void
     */
    public function __construct(
        ResponseHelper $response,
        UserService $userService
    )
    {
        $this->response = $response;
        $this->userService = $userService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleFriend($id)
    {
        $userFriends = $this->userService->toggleFriend($id);

        if ($userFriends) {
            return $this->response->successResponse(true, 'friend Removed', [], 200);
        }
        
        return $this->response->successResponse(true, 'friend Added', [], 200);
    }

}
