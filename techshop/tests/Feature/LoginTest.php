<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_must_be_a_valid_format_for_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'afgdye', // Sai định dạng email
            'password' => 'password',
        ]);

        // Laravel validator sẽ trả lỗi ở trường 'email'
        $response->assertSessionHasErrors(['email']);

        // Chưa login được
        $this->assertGuest();
    }

    /** @test */
    public function user_login_wrong_password(): void
    {
        // Tạo user thật trong DB
        $user = User::factory()->create([
            'email' => 'dinhthang@gmail.com',
            'password' => Hash::make('Thang123@'),
        ]);

        // Thử đăng nhập sai mật khẩu
        $response = $this->post(route('login'), [
            'email' => 'dinhthang@gmail.com',
            'password' => 'Thang12345', // sai
        ]);

        // Laravel redirect về trang login
        $response->assertStatus(302);
        $response->assertSessionHasErrors(); // Có lỗi đăng nhập
        $this->assertGuest(); // User chưa login
        dump(session('errors')->all());

    }
}
