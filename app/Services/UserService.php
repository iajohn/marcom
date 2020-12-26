<?php

namespace App\Services;

// use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryContract;

class UserService
{
    /**
     * @var UserRepositoryContract
     * 
     */
    protected $userRepositoryContract;

    /**
     * @var UserService constructor
     * 
     * @param UserRepositoryContract $userRepositoryContract
     * @return void
     */
    public function __construct(UserRepositoryContract $userRepositoryContract)
    {
        $this->userRepositoryContract = $userRepositoryContract;
    }

    /**
     * @param array $data
     * @return user
     */
    public function registerUser(array $data)
    {
        $splitName = explode(' ', $data['name'], 2);

        $first_name = $splitName[0];
        $last_name = !empty($splitName[1]) ? $splitName[1] : '';
        
        $userData = [
            'name'       => $data['name'],
            'email'      => $data['email'],
            'username'   => $data['username'],
            'password'   => bcrypt($data['password']),
            'first_name' => $first_name,
            'last_name'  => $last_name,
        ];

        return $this->userRepositoryContract->registerUser($userData);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Auth\Authenticatable|null|false
     */
    public function loginUser(array $data)
    {
        $credential = $data['username'];
        $field = filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $credential]);

        
        if (Auth::attempt(request()->only($field, 'password'))) {

            return getLoggedInUser();

        }

        return false;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Auth\Authenticatable|null|false
     */
    public function logoutUser(array $data)
    {
        $credential = $data['username'];
        $field = filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $credential]);

        
        if (Auth::attempt(request()->only($field, 'password'))) {

            return getLoggedInUser();
            
        }

        return false;
    }


    /**
     * @param string $email
     * @return bool
     */
    public function checkIfUserIsVerified(string $username)
    {
        $checkIfExists = $this->userRepositoryContract->checkIfEmailOrUsernameExists($username);

        if ($checkIfExists && $checkIfExists->email_verified_at && $checkIfExists->is_active == 1) {

            return $checkIfExists;
        }
        return false;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function checkEmail(string $email)
    {
        $checkIfEmailExists = $this->userRepositoryContract->checkIfEmailExists($email);
        if ($checkIfEmailExists) {
            return true;
        }

        return false;
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getUserByEmail(string $email)
    {
        return $this->userRepositoryContract->getUserByEmail($email);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getFriends()
    {
        return auth()->user()->friends()->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function toggleFriend(int $id)
    {
        return $this->userRepositoryContract->toggleFriend($id);
    }
}
