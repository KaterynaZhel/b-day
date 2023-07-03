<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreetingCompany extends Model
{
    use HasFactory;
    protected $fillable = ['message_company', 'name_company', 'celebrant_id', 'status'];
}
