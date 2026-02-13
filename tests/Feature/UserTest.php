<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_uses_professional_email(): void
    {
        $user = new User(['email' => 'john@company.com']);
        $this->assertTrue($user->usesProfessionalEmail());
    }
    public function test_user_uses_personal_email(): void
    {
        $user = new User(['email' => 'john@gmail.com']);
        $this->assertFalse($user->usesProfessionalEmail());
    }
}
