<?php

namespace App\Repositories\Contracts;

interface PasswordResetRepositoryContract
{
    /**
     * @param string $email
     * 
     * @return mixed
     * 
     */
    public function createPasswordReset(string $email);

    /**
     * @param string $email
     * @param string $token
     * 
     * @return mixed
     * 
     */
    public function checkPasswordReset(string $email, string $token);

}