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

    public function books()
    {
        return $this->hasMany(Book::class, 'publisher_id');
    }
}
