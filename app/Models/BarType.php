<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specification;
use App\Models\VisitedBar;
use App\Models\bookmark;
use App\Models\Review;
use Laravel\Scout\Searchable;

class BarType extends Model
{
    use Searchable;
    use HasFactory;

    protected $fillable = [
        'type',
        'image',
        'title',
        'latitude',
        'longtitude',
        'facebook',
        'twitter',
        'instagram',
        'description',
        'specification',
        'status'
    ];
    
    public function specifications()
    {
        return $this->hasMany(Specification::class, 'bar_id', 'id'); 
    }
    
    public function barVisit()
    {
        return $this->hasMany(VisitedBar::class);
    }
    
    public function bookmark()
    {
        return $this->hasMany(bookmark::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($barType) {
            event(new \App\Events\BarTypeDeleting($barType));
        });
    }
}
