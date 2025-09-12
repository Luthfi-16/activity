<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
     protected $fillable = ['nik', 'name', 'gender', 'birthplace', 'birthday', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
