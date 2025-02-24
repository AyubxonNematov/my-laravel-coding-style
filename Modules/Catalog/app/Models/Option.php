<?php

namespace Modules\Catalog\Models;

use App\Models\BaseModel;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Catalog\Database\Factories\OptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends BaseModel
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'value',        
        'filter',   
        'specification_id', 
    ];
    
    protected $translatable = ['value'];

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }

    public function scopeFilter($query)
    {
        QueryBuilder::for($query)                  
            ->allowedFilters([
                'specification_id',
            ]);
    }
}

