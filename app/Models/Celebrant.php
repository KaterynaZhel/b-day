<?php

namespace App\Models;

use App\Casts\CelebrantPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebrant extends Model
{
    use HasFactory;
    protected $fillable = ['lastname', 'firstname', 'middlename', 'birthday', 'position'];

    protected $casts = [
        'position' => CelebrantPosition::class
    ];
}