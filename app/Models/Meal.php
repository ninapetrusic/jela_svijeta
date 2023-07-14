<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \Astrotomic\Translatable\Translatable;

    protected $fillable = [
        'title', 'description', 'category'
    ];
    public $translatedAttributes = ['title'];
    protected $visible = ['id', 'description', 'status', 'title', 'tags', 'ingredients', 'categories'];

    public function ingredients(): BelongsToMany {
        return $this->belongsToMany(Ingredient::class);
    }
    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }
    public function categories(): HasOne {
        return $this->hasOne(Category::class, 'id', 'category');
    }
}
