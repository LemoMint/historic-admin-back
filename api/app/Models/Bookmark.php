<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        "page",
        "document_id"
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
