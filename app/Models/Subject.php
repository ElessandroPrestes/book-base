<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{

    use HasFactory;

    protected $fillable = [
        'description',
    ];
    
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_subject')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }
}
