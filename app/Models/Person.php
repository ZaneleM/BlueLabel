<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property int id_number
 * @property  string $mobile_number
 * @property  string $email
 * @property  string $birth_date
 * @property  int $language_id
 */
class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $fillable = ['name', 'surname', 'id_number', 'mobile_number', 'email', 'birth_date', 'language_id'];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }
}
