<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = ["name", "instructions"];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
