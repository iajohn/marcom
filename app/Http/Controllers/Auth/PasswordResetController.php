<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Mail\PasswordResetMail;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\PasswordResetService;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\PasswordResetRequest;

class PasswordResetController extends Controller
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
     * @var PasswordResetService
     * 
     */
    protected $passwordResetService;

    /**
     * @var PasswordResetController constructor
     * 
     * @param UserService $userService
     * @param ResponseHelper $response
     * @param PasswordResetService $passwordResetService
     * @return void
     */
    public function __construct(
        UserService $userService,
        ResponseHelper $response,
        PasswordResetService $passwordResetService
    ) {

        $this->response = $response;
        $this->userService = $userService;
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Forget Password Mail
     * 
     * @param \Illuminate\Http\Request
     * @var ResponseHelper $response
     * @return \Illuminate\Http\JsonResponse
     * 
     * @TODO: create custom request validation
     */
    public function forgetPassword(Request $request)
    {
        $checkUserEmail = $this->userService->checkEmail($request->email);

        if (!$checkUserEmail) {
            return $this->response->errorResponse(false, "User email does not exist", 401);
        }

        $passwordResetData = $this->passwordResetService->createPasswordReset($request->email);
        Mail::to($request->email)->send(new PasswordResetMail($passwordResetData));

        return $this->response->successResponse(true, 'Password reset link Sent', $passwordResetData, 200);
    }

    /**
     * Reset Password Link
     * 
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     * 
     * @TODO: create custom request validation
     */
    public function resetPassword(PasswordResetRequest $request, $token)
    {
        $checkReset = $this->passwordResetService->checkPasswordReset($request->email, $token);

        if (!$checkReset) {
            return $this->response->errorResponse(false, "User email or token does not match", 400);
        }

        $user = $this->userService->getUserByEmail($request->email);
        if (!$user) {
            return $this->response->errorResponse(false, "User not found", 400);
        }

        $this->passwordResetService->updateForgottonPassword($request->password, $request->email, $token);
        
        return $this->response->successResponse(true, "password reset successfull", $user, 200);

    }
}
