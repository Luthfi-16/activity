<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function fieldwork()
    {
        return $this->hasMany(Fieldwork::class);
    }
}
