<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Rating;
use App\Models\Transaction;
use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use CascadeSoftDeletes;
    use HasFactory;
    use SoftDeletes;

    /**
     * A collection of model relationships for cascading soft deletes automatically.
     *
     * @var string[]
     */
    protected $cascadeDeletes = [
        'carts',
        'ratings',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'label',
        'qty',
        'price',
        'size',
        'detail',
        'category',
    ];

    /**
     * Model relationship definition.
     * Product has many Carts
     *
     * @return HasMany
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    /**
     * Model relationship definition.
     * Product has many Ratings
     *
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'product_id');
    }

    /**
     * Model relationship definition.
     * Product belongs to many Users
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ratings');
    }
}
