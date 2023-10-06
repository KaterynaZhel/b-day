<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HobbyCelebrant extends Model
{
    use HasFactory;
    protected $fillable = ['hobby_id', 'celebrant_id'];
}