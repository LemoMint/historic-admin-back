<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    public const DEFAULT_DISK = 'documents';

    public function publication()
    {
        return $this->hasOne(Publication::class);
    }

    protected $fillable = [
        'title'
    ];

    public function documents()
    {
        $this->belongsToMany(Publication::class);
    }
}
