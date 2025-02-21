<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spouse extends Model
{
    protected $table = 'spouses';

    protected $fillable = [
        'gender',
        'name',
        'lastname',
        'surname',
        'birth_year',
        'death_year',
        'description',
        'image_path',
        'person_id',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
