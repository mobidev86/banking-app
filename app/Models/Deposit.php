<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deposit extends Model
{
    use HasFactory;
    protected $table = 'deposit';

    protected $fillable = [
        'user_id',
        'deposit_amount',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
