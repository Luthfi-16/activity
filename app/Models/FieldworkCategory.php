<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldworkCategory extends Model
{
    protected $fillable = ['name', 'description'];
    public function fieldwork()
    {
        return $this->hasMany(Fieldwork::class);
    }
}
