<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fieldwork extends Model
{
    protected $fillable = ['description', 'note', 'branch_id', 'category_id', 'status_id'];

    public function branch()
    {
        return $this->belongsTo(Branche::class);
    }

    public function category()
    {
        return $this->belongsTo(Fieldwork_categorie::class, 'category_id');
    }

    public function status()
    {
        return $this->belongsTo(Fieldwork_statuse::class, 'status_id');
    }
}
