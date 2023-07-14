<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use \Astrotomic\Translatable\Translatable;
    use HasFactory;

    protected $fillable = [
        'title', 'slug'
    ];
    public $translatedAttributes = ['title'];
    protected $visible = ['id', 'title', 'slug'];

    public function meals(): HasMany {
        return $this->hasMany(Meal::class, 'category', 'id');
    }
}

