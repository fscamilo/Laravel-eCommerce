<?php

namespace Tests\Mocks;

use App\Repositories\UserRepository;

class MockUserRepository extends UserRepository
{
    
    public function create($data) {
        return true;
    }

}
