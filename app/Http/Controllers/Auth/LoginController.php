<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * @var UserService
     * 
     */
    protected $userService;

    /**
     * @var ResponseHelper
     * 
     */
    protected $response;

    /**
     * @var LoginController constructor
     * 
     * @param UserService $userService
     * @param ResponseHelper $response
     * @return void
     */
    public function __construct(
        UserService $userService,
        ResponseHelper $response
    ) {
        $this->userService = $userService;
        $this->response = $response;
    }

    /**
     * login user
     */
    public function login(LoginRequest $request)
    {
        $checkVerified = $this->userService->checkIfUserIsVerified($request->username);
        
        if (!$checkVerified) {
            return $this->response->errorResponse(
                false, 
                "Your account is not active yet. Please, verify your email to activate your account.",
                Response::HTTP_UNAUTHORIZED
            );
        }
        
        $user = $this->userService->loginUser($request->all());
        
        if ($user) {
            $token = $user->createToken('Personal Access Token');
            $user->update(['is_online' => 1, 'last_seen' => null]);


            return response()->json([
                'access_token' => $token->accessToken,
                'user' => $user,
            ]);
        }

        return $this->response->errorResponse(false, 'Unauthorised', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * logout user
     * 
     * @return JsonResponse
     */
    public function logout() {
        $authUser = getLoggedInUser();
        $userTokens = $authUser->tokens;

        foreach ($userTokens as $token) {
            /** var Laravel\Passport\Token $token */
            $token->revoke();
        }

        $authUser->update(['is_online' => 0, 'last_seen' => Carbon::now()]);
        return $this->response->successResponse(
            true, 
            "You have logged out successfully.",
            $authUser,
            Response::HTTP_OK
        );
    }
}
