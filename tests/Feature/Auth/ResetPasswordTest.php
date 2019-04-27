<?php

namespace Tests\Feature\Auth;

use App\User;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordPage()
    {
        $response = $this->get(route('password.reset', [
            'token' => 'fake-token',
        ]));

        $response->assertSuccessful();
    }

    public function testResetPassword()
    {
        $user = factory(User::class)->create();
        DB::insert('INSERT INTO password_resets (`email`, `token`, `created_at`) VALUES (?, ?, ?)', [
            $user->email,
            Hash::make('custom-token'),
            now()
        ]);

        $response = $this->post(route('password.update'), [
            'email' => $user->email,
            'token' => 'custom-token',
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseMissing('password_resets', [
            'email' => $user->email,
        ]);
        $this->assertTrue(
            Hash::check('new_password', User::find($user->id)->password)
        );
    }
}
