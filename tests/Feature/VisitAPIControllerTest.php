<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VisitAPIControllerTest extends TestCase
{
    public function testGetData()
    {
        $this->markTestSkipped();
        // Buat user baru
        $user = User::factory()->create();
        Sanctum::actingAs($user);//registrasikan dgn sanctum

        // ambil token user
        $token = $user->createToken('test-token')->plainTextToken;

        $this->withHeaders([
            'Authorization' => 'Beater '. $token
        ])
            ->json('GET','/api/pendaftaran/get')
            ->assertStatus(200)
            ->assertSeeText('success')
            ->assertStatus('true')
            ->assertStatus('data');
    }

}
