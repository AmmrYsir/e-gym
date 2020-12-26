<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    protected $fillable = ['user_id', 'firstname', 'lastname', 'phone_number', 'age', 'address', 'created_at', 'updated_at'];

    protected $guarded = ['id', 'membership_point'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}