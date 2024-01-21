<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @package App\Models
 * @property int $id
 * @property string $publisher_name 
 */
class Publisher extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'publisher_name',
    ];

    public $timestamps = false;

    /**
     * @param array $publisherData
     * @return self 作成された出版社インスタンス
     */
    public static function createPublisher(array $publisherData)
    {
        return self::create($publisherData);
    }

    /**
     * @param array $publisherData
     * @return self 更新された出版社インスタンス
     */
    public function updatePublisher(array $publisherData)
    {
        $this->fill($publisherData);
        $this->save();
        return $this;
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'publisher_id');
    }

    public function authors()
    {
        return $this->hasManyThrough(
            Author::class,
            Book::class,
            'publisher_id',
            'id',
            'id',
            'author_id'
        );
    }
}
