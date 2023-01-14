<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountsResource;
use Illuminate\Http\Request;
use App\Services\AccountService;

class AccountController extends Controller
{
    public function __construct (AccountService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request, $transaction_id)
    {
        $result = $this->service->processTransaction($transaction_id, $request);
        return new AccountsResource($result);
    }

    public function index($user_id)
    {
        $result = $this->service->history($user_id);
        return AccountsResource::collection($result);
    }

    public function show($user_id)
    {
        $result = $this->service->balance($user_id);
        return response()->json($result);
    }
}
