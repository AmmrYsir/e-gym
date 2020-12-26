<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_History extends Model
{
    use HasFactory;
    protected $table = 'transaction_history';

    protected $fillable = ['user_id', 'subscription_id', 'duration', 'transaction_date', 'transaction_total', 'created_at', 'updated_at'];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(subscription::class);
    }
}