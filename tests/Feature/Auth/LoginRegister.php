<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginRegister extends TestCase
{
    use RefreshDatabase;

    public function testLoginPage()
    {
        $response = $this->get(route('login'));

        $response->assertSuccessful();
    }

    public function testLogin()
    {
        $user = factory(User::class)->make();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertTrue(Auth::check());
    }
}
