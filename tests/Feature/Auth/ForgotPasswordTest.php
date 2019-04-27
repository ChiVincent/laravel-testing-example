<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testForgotPasswordPage()
    {
        $response = $this->get(route('password.request'));

        $response->assertSuccessful();
    }

    public function testForgotPassword()
    {
        Notification::fake();
        $user = factory(User::class)->create();

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email,
        ]);
        Notification::assertSentTo($user, ResetPassword::class);
    }
}
