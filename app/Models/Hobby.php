<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function celebrants()
    {
        return $this->belongsToMany(Celebrant::class, 'hobby_celebrant', 'hobby_id', 'celebrant_id');
    }
}