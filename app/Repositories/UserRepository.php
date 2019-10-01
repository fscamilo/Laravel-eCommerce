<?php

namespace App\Repositories;

use App\User;

class UserRepository
{

    public function create($data)
    {
        return User::create($data);
    } 

}