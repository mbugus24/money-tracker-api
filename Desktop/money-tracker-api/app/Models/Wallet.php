<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
    ];

    protected $appends = [
        'balance',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getBalanceAttribute(): float
    {
        if ($this->relationLoaded('transactions')) {
            $income = $this->transactions
                ->where('type', Transaction::TYPE_INCOME)
                ->sum('amount');
            $expense = $this->transactions
                ->where('type', Transaction::TYPE_EXPENSE)
                ->sum('amount');

            return (float) ($income - $expense);
        }

        $income = $this->transactions()
            ->where('type', Transaction::TYPE_INCOME)
            ->sum('amount');
        $expense = $this->transactions()
            ->where('type', Transaction::TYPE_EXPENSE)
            ->sum('amount');

        return (float) ($income - $expense);
    }
}
