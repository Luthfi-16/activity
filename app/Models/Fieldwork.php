<?php

namespace App\Models;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Model;

class Fieldwork extends Model
{
    protected $fillable = ['description', 'note', 'branch_id', 'category_id', 'status_id', 'start_date', 'end_date'];

    public $incrementing = false;    // id bukan auto increment
    protected $keyType   = 'string'; // id berupa string

     protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($fieldwork) {
            if (! $fieldwork->id) {
                $client     = new Client();
                $fieldwork->id = $client->generateId(11); // generate NanoID panjang 11
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function category()
    {
        return $this->belongsTo(FieldworkCategory::class, 'category_id');
    }

    public function status()
    {
        return $this->belongsTo(FieldworkStatus::class, 'status_id');
    }

    public function users()
    {
    return $this->belongsToMany(User::class, 'user_fieldworks', 'fieldwork_id', 'user_id');
    }

}
