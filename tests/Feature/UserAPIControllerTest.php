<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserAPIControllerTest extends TestCase
{
    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertSeeText('User login successfully');
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginEmailNotExist()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => null,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422)
            ->assertSeeText('The email field is required.');
    }

    public function testLoginPasswordNotExist()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(404)
            ->assertSeeText('Email atau password anda salah !');
    }

    public function testRegister()
    {
        $response = $this->json('POST','/api/register',[
            'name' => 'People Testing',
            'email' => 'people@example.com',
            'password' => 'password',
            'c_password' => 'password',
        ]);

        $response->assertSeeText('Pendaftaran Berhasil dilakukan.');
    }

    public function testValidateRegister()
    {
        //test register tanpa name
        $this->json('POST','/api/register')
            ->assertStatus(404)
            ->assertSeeText('The name field is required.');

        //test register tanpa email
        $input = [
            'name' => 'Testing',
        ];
        $this->json('POST','/api/register',$input)
            ->assertStatus(404)
            ->assertSeeText('The email field is required.');

        //test register tanpa password
        $input['email'] = 'test@example.com';
        $this->json('POST','/api/register',$input)
            ->assertStatus(404)
            ->assertSeeText('The password field is required.');

        //test register tanpa c_password
        $input['password'] = 'password';
        $this->json('POST','/api/register',$input)
            ->assertStatus(404)
            ->assertSeeText('The c password field is required.');
    }


}
