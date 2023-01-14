<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct (UserService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        $result = $this->service->create($request->only('name', 'password'));
        return new UserResource($result);
    }
}
