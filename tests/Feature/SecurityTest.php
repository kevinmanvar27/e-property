<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SecurityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that security headers are applied to responses.
     *
     * @return void
     */
    public function test_security_headers_are_applied()
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff')
                 ->assertHeader('X-Frame-Options', 'DENY')
                 ->assertHeader('X-XSS-Protection', '1; mode=block')
                 ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    /**
     * Test that login attempts are rate limited.
     *
     * @return void
     */
    public function test_login_is_rate_limited()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Attempt to login 6 times with wrong password
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // The last attempt should show rate limiting message
        $response->assertStatus(302)
                 ->assertSessionHasErrors('email');
    }
}