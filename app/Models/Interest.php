<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 */
class Interest extends Model
{
    use HasFactory;

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
