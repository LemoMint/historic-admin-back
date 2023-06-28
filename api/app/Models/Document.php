<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    public const DEFAULT_DISK = 'documents';
    private const IMAGE_TOPIC_EXTS = ['jpg', 'png'];

    protected $fillable = [
        'title'
    ];

    public function publication()
    {
        return $this->hasOne(Publication::class);
    }

    public function bookmars()
    {
        return $this->hasMany(Bookmark::class);
    }

    // public function documents()
    // {
    //     $this->belongsToMany(Publication::class);
    // }

    public function isImageTopic()
    {
        return in_array($this->extension, self::IMAGE_TOPIC_EXTS);
    }


}
