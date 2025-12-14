<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'birth_date' => 'date',
    ];
    protected $dates = [
        'birth_date',
    ];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
