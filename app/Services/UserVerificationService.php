<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\Contracts\UserVerificationRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;

class UserVerificationService
{
    /**
     * @var UserVerificationRepositoryContract
     */
    protected $userVerificationRepositoryContract;

    /**
     * @var UserRepositoryContract
     */
    protected $userRepositoryContract;

    /**
     * @var UserVerificationService constructor
     * 
     * @param UserRepositoryContract $userRepositoryContract
     * @param UserVerificationRepositoryContract $userVerificationRepositoryContract
     * @return void
     * 
     */
    public function __construct(
        UserVerificationRepositoryContract $userVerificationRepositoryContract, 
        UserRepositoryContract $userRepositoryContract
    )
    {
        $this->userVerificationRepositoryContract = $userVerificationRepositoryContract;
        $this->userRepositoryContract = $userRepositoryContract;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function generateToken(int $userId)
    {
        $token = Str::random(16);

        return $this->userVerificationRepositoryContract->generateToken($userId, $token);
        
    }


    /**
     * @param  string  $username
     * @param  string  $email
     * @param  string  $verificationCode
     * @param  string  $url
     *
     * @throws Throwable
     */
    public function sendConfirmEmail($username, $email, $verificationCode, $url)
    {
        return $this->userVerificationRepositoryContract->sendConfirmEmail($username, $email, $verificationCode, $url);   
    }


    /**
     * @param string $token
     * @return mixed
     */
    public function checkToken(string $token)
    {
       $checkToken = $this->userVerificationRepositoryContract->checkToken($token);
        
        if ($checkToken) {
            $userId = $checkToken->user_id;
            $this->userRepositoryContract->verifyUser($userId); 
            $checkToken->delete();

            return true;
        }

        return false;
    }
    
}
