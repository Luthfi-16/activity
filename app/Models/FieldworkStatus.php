<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldworkStatus extends Model
{
    protected $fillable = ['name', 'description'];

    public function fieldwork()
    {
        return $this->belongsTo(Fieldwork::class);
    }
}
