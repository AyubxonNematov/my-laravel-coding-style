<?php

namespace Modules\Catalog\Models;

use App\Models\BaseModel;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// used denormalization
class Category extends BaseModel
{
    use HasFactory, NodeTrait;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'icon',
        'photo',
        'photo_focus',
        'coefficient',
        'coefficient_commissioner',
        'coefficient_extra',
        'status',
        'type',
        'position',
        'parent_id',
    ];

    protected $translatable = ['name'];

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected $casts = [
        'icon' => 'array',
        'photo' => 'array',
        'photo_focus' => 'array',
    ];

    public function specifications(): HasMany
    {
        return $this->hasMany(Specification::class, 'leaf_category_id');
    }

    public function scopeFilter($query)
    {
        QueryBuilder::for($query)                  
            ->allowedFilters([
                'parent_id',
            ])
            ->allowedIncludes([
                'children',
            ]);
    }
}
