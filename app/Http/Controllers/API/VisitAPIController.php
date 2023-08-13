<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Services\VisitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitAPIController extends BaseController
{
    private VisitService $visitService;

    public function __construct(VisitService $visitService)
    {
        $this->visitService = $visitService;
    }

    public function getData(Request $request): JsonResponse
    {
        $data = $this->visitService->getData($request);

        if(is_null($data)){
            return $this->sendError('Something Wrong !');
        }

        return $this->sendResponse($data,'Data berhasil diambil');
    }

    public function getKabupaten(Request $request): JsonResponse
    {
        $data = $this->visitService->getKabupaten($request);

        if(is_null($data)){
            return $this->sendError('Something Wrong !');
        }

        return $this->sendResponse($data,'Data berhasil diambil');
    }
}
