<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\PasswordResetRepositoryContract;

class PasswordResetService
{
    /**
     * @var PasswordResetRepositoryContract
     */
    protected $passwordResetRepositoryContract;

    /**
     * @var PasswordResetService constructor
     * @param PasswordResetRepositoryContract $passwordResetRepositoryContract
     * @return void
     * 
     */
    public function __construct(PasswordResetRepositoryContract $passwordResetRepositoryContract)
    {
        $this->passwordResetRepositoryContract = $passwordResetRepositoryContract;
    }

    /**
     * 
     * @param  string $email
     * @return mixed
     */
    public function createPasswordReset(string $email)
    {
        return $this->passwordResetRepositoryContract->createPasswordReset($email);
    }

    /**
     * This checks to see if password reset token exists,
     * it create new password for user, delete token then 
     * returns boolean
     * 
     * @param string $email
     * @param string $token
     * 
     * @return bool
     */
    public function checkPasswordReset(string $email, string $token)
    {
        return $this->passwordResetRepositoryContract->checkPasswordReset($email, $token);
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function updateForgottonPassword(string $password, string $email, string $token)
    {
        $checkReset = $this->passwordResetRepositoryContract->checkPasswordReset($email, $token);

        if ($checkReset) {
            $userEmail = $checkReset->email;
            $user = User::where(['email' => $userEmail])->first();
            $user->password = bcrypt($password);
            $user->save();
            $checkReset->delete();

            return true;
        }

        return false;
    }
}
