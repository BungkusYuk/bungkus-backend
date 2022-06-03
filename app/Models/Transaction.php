<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'address_id',
        'qty_transaction',
        'subtotal_products',
        'total_price',
        'status',
        'invoice_number',
        'shipping_cost',
    ];

    /**
     * Model relationship definition.
     * Transaction has many ProductTransactions
     *
     * @return HasMany
     */
    public function productTransactions(): HasMany
    {
        return $this->hasMany(ProductTransaction::class, 'transaction_id')
            ->leftJoin('transactions','product_transactions.transaction_id','=','transactions.id')
            ->leftJoin('products','product_transactions.product_id','=','products.id')
            ->leftJoin('carts','carts.product_id','=','products.id')
            ->select([
                'products.*',
                'product_transactions.*',
                'carts.product_qty',
            ]);
    }

    /**
     * Model relationship definition.
     * Transaction belongs to User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Model relationship definition.
     * Transaction belongs to Address
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
