<?php

namespace App\Marketplace;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    protected $table = 'marketplace_listings';

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'name',
        'detail',
        'country',
        'state',
        'city',
        'area',
        'price',
        'image_path',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
