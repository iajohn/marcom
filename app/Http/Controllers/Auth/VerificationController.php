<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\UserVerificationService;

class VerificationController extends Controller
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
     * @var UserVerificationService
     * 
     */
    protected $userVerificationService;

    /**
     * @var VerificationController constructor
     * 
     * @param UserService $userService
     * @param ResponseHelper $response
     * @param UserVerificationService $userVerificationService
     * @return void
     */
    public function __construct(
        UserService $userService,
        ResponseHelper $response,
        UserVerificationService $userVerificationService
    ) {

        $this->userService = $userService;
        $this->response = $response;
        $this->userVerificationService = $userVerificationService;
    }

    /**
     * Verify Email Link
     * 
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($token)
    {
        $checkToken = $this->userVerificationService->checkToken($token);

        return $this->response->successResponse(true, "Email verified, please login", $checkToken, 200);
    }

    

}
