<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Subscription extends Model
{
    use HasFactory;
    protected $table = 'user_subscription';

    protected $fillable = ['id', 'user_id', 'duration', 'trial', 'subscription_id', 'subscription_start', 'trial_end', 'status', 'subscription_end', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }
}