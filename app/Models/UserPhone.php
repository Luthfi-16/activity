<?php

namespace App\Models;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    protected $fillable = ['number', 'name', 'user_id'];
    public $incrementing = false;    // id bukan auto increment
    protected $keyType   = 'string'; // id berupa string

    protected static function booted()
    {
        static::creating(function ($userphone) {
            if (! $userphone->id) {
                $client     = new Client();
                $userphone->id = $client->generateId(11); // generate NanoID panjang 11
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
