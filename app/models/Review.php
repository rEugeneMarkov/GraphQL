<?php

namespace App\Models;

use App\Models\Book;

class Review extends Model
{
    protected static $table = 'reviews';

    public function book()
    {
        return Book::find($this->book_id);
    }
}
