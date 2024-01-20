<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Models
 * @property string $isbn
 * @property string $book_name
 * @property string $published_at
 * @property string $author_id
 * @property string $publisher_id
 */
class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'isbn';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['published_at'];

    protected $fillable = [
        'isbn',
        'book_name',
        'published_at',
        'author_id',
        'publisher_id'
    ];

    public $timestamps = false;

    /**
     * @param array $data 書籍のデータ
     * @return self 作成された書籍インスタンス
     */
    public static function createBook(array $data)
    {
        return self::create($data);
    }

    /**
     * @param array $data 更新する書籍のデータ
     * @return self 更新された書籍インスタンス
     */
    public function updateBook(array $data)
    {
        $this->fill($data);
        $this->save();
        return $this;
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function getRouteKeyName()
    {
        return 'isbn';
    }
}
