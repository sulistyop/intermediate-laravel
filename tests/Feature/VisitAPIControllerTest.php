<?php

namespace Tests\Feature;

use App\Services\VisitService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VisitAPIControllerTest extends TestCase
{
    private VisitService $visitService;
    private $baseUrl;
    protected function setUp(): void
    {
       parent::setUp();
       $this->visitService = $this->app->make(VisitService::class);
       $this->baseUrl = env('APP_URL','http://localhost:8000').'/api/';
    }

//    public function testGetVisit()
//    {
//        $this->withBasicAuth()
//    }


}
