<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscription';

    protected $fillable = ['name', 'desc', 'type', 'trial_able', 'trial_duration_in_weeks', 'parent_id', 'duration', 'created_at', 'updated_at'];

    protected $casts = [
        'duration' => 'array',
    ];

    protected $guarded = ['id'];

    public function user_subscription()
    {
        return $this->hasOne(User_Subscription::class, 'subscription_id', 'id');
    }

    public function transaction_history()
    {
        return $this->hasOne(Transaction_History::class, 'subscription_id', 'id');
    }
}