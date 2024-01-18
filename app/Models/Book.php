<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Models
 * @property string $isbn
 * @property string $book_name
 * @property string $published_at
 */
class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'isbn';

    protected $fillable = [
        'isbn',
        'book_name',
        'published_at'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }
}
