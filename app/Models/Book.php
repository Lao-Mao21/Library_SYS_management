<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'author',
        'isbn',
        'publication_year',
        'category_id', // Nullable foreign key
        'publisher',
        'page_count',
        'language',
        'is_deleted',
        'is_available',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'page_count' => 'integer',
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
        return $this->hasMany(Category::class);
    }

     /**
     * Scope a query to only include non-deleted books.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_deleted', false);
    }

    /**
     * Scope a query to only include deleted books.
     */
    public function scopeDeleted(Builder $query): void
    {
        $query->where('is_deleted', true);
    }
}
