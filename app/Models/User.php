<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function account(): HasOne {
        return $this->hasOne(Account::class);
    }
    public function transactions(): HasMany {
        return $this->hasMany(Transaction::class);
    }
}
