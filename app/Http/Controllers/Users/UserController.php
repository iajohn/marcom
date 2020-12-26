<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Services\UserService;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
     * @var UserController constructor
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // $user_id = Auth::user()->id;
        // $user = User::with('notebooks')->find($user_id);

        $user = Auth::user();
        return $this->response->successResponse(true, 'current user profile', $user, 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFriends()
    {
        // $userFriends = auth()->user()->friends()->get();

        $userFriends = $this->userService->getFriends();
        return $this->response->successResponse(true, 'Friends', $userFriends, 200);
    }
}
