<?php

namespace Tests\Feature;

use App\Services\VisitService;
use Tests\TestCase;

class VisitServiceTest extends TestCase
{
    private VisitService $visitService;
    protected function setUp(): void
    {
        parent::setUp();
        $this->visitService = $this->app->make(VisitService::class);
    }

    public function testSuccess()
    {
        self::assertTrue(true);
    }


}
