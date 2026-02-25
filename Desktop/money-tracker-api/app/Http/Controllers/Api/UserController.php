<?php
#User endpoints
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        $user->load('wallets.transactions');

        $wallets = $user->wallets->map(function ($wallet) {
            return [
                'id' => $wallet->id,
                'name' => $wallet->name,
                'balance' => $wallet->balance,
            ];
        });

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'wallets' => $wallets,
            'total_balance' => (float) $wallets->sum('balance'),
        ]);
    }
}
