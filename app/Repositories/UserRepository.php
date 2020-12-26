<?php

namespace App\Repositories;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    /**
     * @param  array  $data
     * @return mixed
     */
    public function registerUser(array $data)
    {
        try {
            $newUser = new User();
            $newUser->fill($data);
            $newUser->save();

            return $newUser;
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function verifyUser(int $userId)
    {
        try {
            $user = User::where(['id' => $userId])->first();
            $user->email_verified_at = Carbon::now();
            $user->is_active = 1;
            $user->save();
            
            return $user;
        } catch (Throwable $error) {
            return $error->getMessage();
        }
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function checkIfEmailOrUsernameExists(string $username)
    {
        try {

            $fieldType = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            request()->merge([$fieldType => $username]);
            $user = User::where(['email' => request()->only($fieldType)])->orWhere(['username' => request()->only($fieldType)])->first();

            return $user;
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }

    /**
     * @param string $email
     * 
     * @return mixed
     * 
     */
    public function getUserByEmail(string $email)
    {
        try {

            return User::where(['email' => $email])->first();

        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }

    /**
     * @param int $id
     * 
     * @return mixed
     * 
     */
    public function toggleFriend(int $id)
    {
        try {
            $userFriends = auth()->user()->friends();

            if ($userFriends->find($id)) {
                $detach = $userFriends->detach($id);
                return $detach;
            }

            $attach = $userFriends->attach($id);
            return $attach;

        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }
}
