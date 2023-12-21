<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Std extends Model
{
    use HasFactory;

    public function school()
    {
        return $this->belongsTo(School::class, 'schoolID', 'id');
    }
}
