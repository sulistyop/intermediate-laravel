<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginAPIControllerTest extends TestCase
{
    public function testLoginSuccess()
    {
        $this->post('/api/login',[
            'email' => 'test@gmail.com',
            'password' => '123456',
        ])->assertSeeText('success')
        ->assertSeeText('true')
        ->assertSeeText('User login successfully.');
    }

    public function testLoginFail()
    {
        $this->post('/api/login',[
            'email' => 'test@gmail.com',
            'password' => '123456',
        ])->assertSeeText('success')
            ->assertSeeText('true')
            ->assertSeeText('User login successfully.');
    }
}
