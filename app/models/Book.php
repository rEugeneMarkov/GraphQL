<?php

namespace App\Models;

class Book extends Model
{
    protected static $table = 'books';

    public function author()
    {
        return Author::find($this->author_id);
    }

    public function reviews()
    {
        return Review::where('book_id', '=', $this->id)->get();
    }
}
