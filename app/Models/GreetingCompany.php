<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GreetingStatusEnum;


class GreetingCompany extends Model
{
    use HasFactory;
    protected $fillable = ['message_company', 'name_company', 'celebrant_id', 'status'];

    protected $casts = [
        'status' => GreetingStatusEnum::class
    ];

}