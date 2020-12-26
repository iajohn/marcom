<?php

namespace App\Repositories\Contracts;

interface UserRepositoryContract
{
    /**
     * @param array $data
     * 
     * @return mixed
     * 
     */
    public function registerUser(array $data);

    /**
     * @param int $userId
     * 
     * @return mixed
     * 
     */
    public function verifyUser(int $userId);

    /**
     * @param string $email
     * 
     * @return mixed
     * 
     */
    public function checkIfEmailOrUsernameExists(string $username);

    /**
     * @param string $email
     * 
     * @return mixed
     * 
     */
    public function getUserByEmail(string $email);

    /**
     * @param int $id
     * 
     * @return mixed
     * 
     */
    public function toggleFriend(int $id);
}