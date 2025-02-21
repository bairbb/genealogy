<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;

class Person extends Model
{
    use HasFactory, NodeTrait;

    public $table = 'persons';

    protected $fillable = [
        'name',
        'lastname',
        'surname',
        'birth_year',
        'death_year',
        'description',
        'image_path',
    ];

    public function spouses(): HasMany
    {
        return $this->hasMany(Spouse::class);
    }

    public function getFullNameAttribute(): string
    {
        return "$this->lastname $this->name $this->surname";
    }
}
