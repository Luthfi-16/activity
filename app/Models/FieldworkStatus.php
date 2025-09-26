<?php
namespace App\Models;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Model;

class FieldworkStatus extends Model
{
    protected $fillable = ['name', 'description'];

    public $incrementing = false;    // id bukan auto increment
    protected $keyType   = 'string'; // id berupa string

    protected static function booted()
    {
        static::creating(function ($status) {
            if (! $status->id) {
                $client     = new Client();
                $status->id = $client->generateId(11); // generate NanoID panjang 11
            }
        });
    }

    public function fieldwork()
    {
        return $this->hasMany(Fieldwork::class, 'status_id');
    }
}
