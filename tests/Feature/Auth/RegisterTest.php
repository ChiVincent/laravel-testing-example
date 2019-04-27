<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterPage()
    {
        $response = $this->get(route('register'));

        $response->assertSuccessful();
    }

    public function testRegister()
    {
        $user = factory(User::class)->make();

        $response = $this->post(route('register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $this->assertTrue(
            Hash::check('password', User::where('email', $user->email)->first()->password)
        );
    }
}
