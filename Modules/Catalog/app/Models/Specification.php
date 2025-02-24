<?php

namespace Modules\Catalog\Models;

use App\Models\BaseModel;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specification extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',  
        'type',  
        'filter',   
        'position', 
        'leaf_category_id',   
    ];

    protected $translatable = [
        'name',
    ];

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    } 
    
    public function leafCategory()
    {
        return $this->belongsTo(Category::class, 'leaf_category_id');
    }

    public function scopeFilter($query)
    {
        QueryBuilder::for($query)                  
            ->allowedFilters([
                'leaf_category_id',
            ]);
    }
}

