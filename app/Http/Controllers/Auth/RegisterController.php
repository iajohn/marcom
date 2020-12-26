<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserVerificationService;

class RegisterController extends Controller
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
     * @var UserVerificationService
     * 
     */
    protected $userVerificationService;

    /**
     * @var PasswordResetController constructor
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
     * Register new user 
     * Create a secure token
     * Return as json after a valid registration.
     *
     * @param  RegisterRequest  $request
     * 
     * @throws \Exception
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->userService->registerUser($request->all());
        
        $apiUrl = url('/api');

        if ($user) {
            $verificationCode = $this->userVerificationService->generateToken($user->id);
            $this->userVerificationService->sendConfirmEmail($user->name, $user->email, $verificationCode, $apiUrl);
            return $this->response->successResponse(true, 'Please check your email inbox to confirm your account. Do not forget to check your spam folder as well.', $user, 200);
        }

        return $this->response->errorResponse(false, 'No user found', 404);

    }

}
