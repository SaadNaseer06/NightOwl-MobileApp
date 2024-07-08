<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'bar_id',
        'specification',
    ];
    
    public function barType()
    {
        return $this->belongsTo(BarType::class);
    }
}
