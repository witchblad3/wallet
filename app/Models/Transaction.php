<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'comment',
        'related_user_id',
        'operation_id'
    ];
    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function relatedUser(): BelongsTo {
        return $this->belongsTo(User::class, 'related_user_id');
    }
}
