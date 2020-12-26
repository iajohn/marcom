<?php

namespace App\Repositories;

// use Throwable;
use App\Mail\MarkdownMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Models\UserVerificationToken;
use App\Repositories\Contracts\UserVerificationRepositoryContract;

class UserVerificationRepository implements UserVerificationRepositoryContract
{
    /**
     * Create new email verification token
     * 
     * @param  int $userId
     * @param  string $token
     * @return mixed
     */
    public function generateToken(int $userId, string $token)
    {
        try {
            $newToken = new UserVerificationToken();
            $newToken->user_id = $userId;
            $newToken->token = $token;
            $newToken->save();

            return $newToken;
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }


    /**
     * @param  string  $username
     * @param  string  $email
     * @param  string  $verificationCode
     * @param  string  $url
     *
     * @throws Exception
     */
    public function sendConfirmEmail($username, $email, $verificationCode, $url = '')
    {
        $data['link'] = ($url != '') ? $url.'/api/auth/verify_email/'.$verificationCode : URL::to('/api/auth/verify_email/'.$verificationCode);
        $data['username'] = $username;

        try {
            Mail::to($email)
                ->send(new MarkdownMail('auth.emails.account_verification', 'Verify your account', 'no_reply@incattech.com', $data));

            // Mail::to($user->email)->send(new RegisterUserMail($user, $token->token));

        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }


    /**
     * Check if user email verification token exists
     * 
     * @param  string $token
     * @return mixed
     */
    public function checkToken(string $token)
    {
        try {
            return UserVerificationToken::where(['token' => $token])->first();
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }
}
