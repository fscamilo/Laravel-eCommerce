<?php

namespace Tests\Unit\User;

use App\User;
use Tests\TestCase;
use App\Events\RegisteredUser;
use Tests\Mocks\MockUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\auth\RegisterController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationEventTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserRegistrationEvent()
    {
        
        Event::fake();

        $userController = new RegisterController();
        Auth::shouldReceive('user')->andReturn(new User([
            'id' => 1
        ]));

        User::query()->where('email', 'test@test.com')->delete();

        $userController->create(new MockUserRepository, ['name' => 'test', 'email' => 'test@test.com', 'password' => 'password', 'role' => 'member']);

        Event::assertDispatched(RegisteredUser::class);

    }
}
