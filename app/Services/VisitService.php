<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface VisitService
{
    public function getData($request): array;
    public function getKabupaten($request): array;
}
