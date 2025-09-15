<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hidehalo\Nanoid\Client;


class UserProfile extends Model
{
     protected $fillable = ['nik', 'name', 'gender', 'birthplace', 'birthday', 'user_id'];
      public $incrementing = false;    // bukan auto increment
    protected $keyType   = 'string'; // primary key string

    protected static function booted()
    {
        static::creating(function ($userprofile) {
            if (! $userprofile->id) {
                $client     = new Client();
                $userprofile->id = $client->generateId(11); // panjang 11 karakter
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
