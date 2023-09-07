<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Celebrant;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'site'];

    public function celebrants()
    {
        return $this->hasMany(Celebrant::class, 'company_id', 'id');
    }
}
