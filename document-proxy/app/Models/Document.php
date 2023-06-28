<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public const DEFAULT_DISK = 'documents';
    private const IMAGE_TOPIC_EXTS = ['jpg', 'png'];

    protected $fillable = [
        'disk',
        'extension',
        'file_name',
        'uuid'
    ];

    use HasFactory;

    public function isImageTopic()
    {
        return in_array($this->extension, self::IMAGE_TOPIC_EXTS);
    }
}
