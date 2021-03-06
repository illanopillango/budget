<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserVerificationTest extends TestCase
{
    private $successfulVerificationText = 'You\'ve succesfully verified';

    public function testValidToken(): void
    {
        $token = 123;

        factory(User::class)->create([
            'verification_token' => $token
        ]);

        $response = $this
            ->followingRedirects()
            ->get('/verify/' . $token);

        $response
            ->assertStatus(200)
            ->assertSeeText($this->successfulVerificationText);
    }

    public function testInvalidToken(): void
    {
        $token = 456;

        $response = $this
            ->followingRedirects()
            ->get('/verify/' . $token);

        $response
            ->assertStatus(200)
            ->assertDontSeeText($this->successfulVerificationText);
    }
}
