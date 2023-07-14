<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;
    use \Astrotomic\Translatable\Translatable;
    
    protected $fillable = [
        'title', 'slug'
    ];
    public $translatedAttributes = ['title'];
    protected $visible = ['id', 'title', 'slug'];

    public function meals(): BelongsToMany {
        return $this->belongsToMany(Meal::class);
    }
}
