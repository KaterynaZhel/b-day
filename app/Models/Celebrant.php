<?php

namespace App\Models;

use App\Casts\CelebrantPhoto;
use App\Casts\CelebrantPosition;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebrant extends Model
{
    use HasFactory;
    use Filterable;
    protected $fillable = ['lastname', 'firstname', 'middlename', 'birthday', 'position'];

    protected $casts = [
        'position' => CelebrantPosition::class,
        'photo' => CelebrantPhoto::class,
    ];
}
