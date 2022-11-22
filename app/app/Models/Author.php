<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'patronymic_name'
    ];

    public function publications()
    {
        return $this->belongsToMany(Publication::class);
    }
}
