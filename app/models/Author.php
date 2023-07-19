<?php

namespace App\Models;

use App\Models\Book;

class Author extends Model
{
    protected static $table = 'authors';

    public function books()
    {
        return Book::where('author_id', '=', $this->id)->get();
    }
}
