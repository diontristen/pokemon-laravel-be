<?php
namespace App\Repository;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function findById($id)
    {
        return User::find($id);
    }
    public function getUserDetails($userId)
    {
        return User::find($userId); // Fetch user details by ID
    }
}
