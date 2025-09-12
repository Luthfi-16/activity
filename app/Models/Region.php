<?php

namespace App\Models;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable  = ['name', 'code'];
    public $incrementing = false;    // bukan auto increment
    protected $keyType   = 'string'; // primary key string

    protected static function booted()
    {
        static::creating(function ($region) {
            if (! $region->id) {
                $client     = new Client();
                $region->id = $client->generateId(11); // panjang 11 karakter
            }
        });
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}

