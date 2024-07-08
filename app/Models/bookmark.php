<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bar_id'
    ];
    
    public function barType()
    {
        return $this->belongsTo(BarType::class, 'bar_type_id');
    }
    
    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }
}
