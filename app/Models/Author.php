<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Models
 * @property int $id
 * @property string $author_name 
 */
class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'author_name',
    ];

    public $timestamps = false;

    /**
     * @param array $validatedData
     * @return self 作成された書籍インスタンス
     */
    public static function createAuthor(array $authorData)
    {
        return self::create($authorData);
    }

    /**
     * @param array $authorName
     * @return self 更新された書籍インスタンス
     */
    public function updateAuthor(array $authorData)
    {
        $this->fill($authorData);
        $this->save();
        return $this;
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }

    public function publishers()
    {
        return $this->hasManyThrough(
            Publisher::class,
            Book::class,
            'author_id',
            'id',
            'id',
            'publisher_id'
        );
    }
}
