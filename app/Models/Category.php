<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'description', 'color'])]
class Category extends Model
{
    use HasFactory, HasSlug;

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getColorClassesAttribute(): string
    {
        return match ($this->color) {
            'rose' => 'bg-rose-50 text-rose-700 ring-rose-200',
            'amber' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'sky' => 'bg-sky-50 text-sky-700 ring-sky-200',
            'violet' => 'bg-violet-50 text-violet-700 ring-violet-200',
            default => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        };
    }

    public function getInitialsAttribute(): string
    {
        return Str::of($this->name)->explode(' ')->map(fn ($word) => Str::substr($word, 0, 1))->take(2)->implode('');
    }
}
