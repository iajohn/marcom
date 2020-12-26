<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Repositories\Contracts\PasswordResetRepositoryContract;

class PasswordResetRepository implements PasswordResetRepositoryContract
{
    /**
     * Create new password reset token
     * 
     * @param  string  $email
     * @return \App\Models\User
     */
    public function createPasswordReset(string $email)
    {
        try {

            $newPassword = PasswordReset::updateOrCreate(
                ['email' => $email],
                [
                    'email' => $email,
                    'token' => Str::random(60),
                ]
            );

            return $newPassword;
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }

    /**
     * @param string $email
     * @param string $token
     * 
     * @return mixed
     * 
     */
    public function checkPasswordReset(string $email, string $token)
    {
        try {
            return PasswordReset::where([
                'email' => $email,
                'token' => $token
            ])->first();

             
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }

}
