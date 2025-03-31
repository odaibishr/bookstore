<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'publisher_id',
        'isbn',
        'publish_year',
        'number_of_pages',
        'number_of_copies',
        'description',
        'cover_image',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function rate()
    {
        $ratings = $this->ratings(); 

        return $ratings->exists() 
            ? $ratings->sum('value') / $ratings->count() 
            : 0;
    }
}
