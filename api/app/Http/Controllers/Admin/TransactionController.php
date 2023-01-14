<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TransactionsResource;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{

    public function __construct (TransactionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $result = $this->service->getAllPending();
        return TransactionsResource::collection($result);
    }

    public function update(Request $request)
    {
        $result = $this->service->update($request->only('transaction_id', 'type'));
        return response()->json($result);
    }
}
