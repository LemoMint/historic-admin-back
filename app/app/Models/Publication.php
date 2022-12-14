<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'publication_year',
        'publication_century',
        'user_id',
        'publishing_house_id'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publishingHouse()
    {
        return $this->belongsTo(PublishingHouse::class);
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(DocumentCategory::class);
    // }
}
