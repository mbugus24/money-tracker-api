<?php
#Wallet endpoints
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $wallet = Wallet::create($validated);

        return response()->json($wallet, 201);
    }

    public function show(Wallet $wallet): JsonResponse
    {
        $wallet->load(['transactions' => fn ($query) => $query->latest()]);

        return response()->json([
            'id' => $wallet->id,
            'name' => $wallet->name,
            'user_id' => $wallet->user_id,
            'balance' => $wallet->balance,
            'transactions' => $wallet->transactions,
        ]);
    }
}
