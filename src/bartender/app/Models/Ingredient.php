<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = ["name", "description"];

    public static $resourceType = "ingredients";

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function drinks(): BelongsToMany
    {
        return $this->belongsToMany(Drink::class)->withPivot('measure');
    }
}
