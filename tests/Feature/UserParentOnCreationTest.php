<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function UserParentOnCreationTest()
    {
        $userController = new RegisterController();
        Auth::shouldReceive('user')->andReturn(new User([
            'id' => 1
        ]));

        User::query()->where('email', 'test@test.com')->delete();

        $userController->create(['name' => 'test', 'email' => 'test@test.com', 'password' => 'password', 'role' => 'member']);

        $t = User::query()->where('email', 'test@test.com')->first();

        $this->assertEquals(1, $t->parent);
        
    }
}
