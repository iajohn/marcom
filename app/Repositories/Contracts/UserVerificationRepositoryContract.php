<?php

namespace App\Repositories\Contracts;

interface UserVerificationRepositoryContract
{
    /**
     * @param string $token
     * 
     * @return mixed
     * 
     */
    public function generateToken(int $userId, string $token);


    /**
     * @param  string  $username
     * @param  string  $email
     * @param  string  $verificationCode
     * @param  string  $url
     *
     * @throws Exception
     */
    public function sendConfirmEmail(string $username, string $email, string $verificationCode, string $url = '');

    /**
     * @param string $token
     * 
     * @return mixed
     * 
     */
    public function checkToken(string $token);
}