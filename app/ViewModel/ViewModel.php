<?php

namespace App\ViewModel;

use Illuminate\Http\JsonResponse;

abstract class ViewModel
{
    public function response(array $data) : JsonResponse {
        return response()->json($data);
    }
}
