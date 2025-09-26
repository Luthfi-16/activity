<?php
namespace App\Models;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'region_id'];

    public $incrementing = false;    // id bukan auto increment
    protected $keyType   = 'string'; // id berupa string

    protected static function booted()
    {
        static::creating(function ($branch) {
            if (! $branch->id) {
                $client     = new Client();
                $branch->id = $client->generateId(11); // panjang 11 karakter
            }
        });
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function fieldwork()
    {
        return $this->hasMany(Fieldwork::class);
    }
}
