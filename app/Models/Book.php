<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publisher',
        'edition',
        'publication_year',
        'price',
        'slug',
        'isbn',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'book_subject')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }
}
