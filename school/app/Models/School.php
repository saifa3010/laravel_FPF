<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    public function std()
    {
        return $this->hasMany(Std::class, 'schoolID', 'id');
    }
}
