<?php

namespace App\QueryBuilders;

use App\Http\Requests\ProductGetRequest;
use App\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ProductBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var ProductGetRequest
     */
    protected $request;

    /**
     * ProductBuilder constructor.
     *
     * @param ProductGetRequest $request
     */
    public function __construct(ProductGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Product::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'products.id',
            'products.label',
            'products.qty',
            'products.price',
            'products.size',
            'products.detail',
            'products.category',
            'products.image',
            'products.created_at',
            'products.updated_at',
            'products.deleted_at',
            'transaction.id',
            'transaction.user_id',
            'transaction.qty_transaction',
            'transaction.subtotal_products',
            'transaction.total_price',
            'transaction.status',
            'transaction.created_at',
            'transaction.updated_at',
        ];
    }

    /**
     * Get a list of allowed columns that can be used in any filter operations.
     *
     * @return array
     */
    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            'label',
            AllowedFilter::exact('qty'),
            AllowedFilter::exact('price'),
            AllowedFilter::exact('size'),
            'detail',
            'category',
            'image',
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('deleted_at'),
            AllowedFilter::exact('products.id'),
            'products.label',
            AllowedFilter::exact('products.qty'),
            AllowedFilter::exact('products.price'),
            AllowedFilter::exact('products.size'),
            'products.detail',
            'products.category',
            'products.image',
            AllowedFilter::exact('products.created_at'),
            AllowedFilter::exact('products.updated_at'),
            AllowedFilter::exact('products.deleted_at'),
            AllowedFilter::exact('transaction.id'),
            AllowedFilter::exact('transaction.user_id'),
            AllowedFilter::exact('transaction.qty_transaction'),
            AllowedFilter::exact('transaction.subtotal_products'),
            AllowedFilter::exact('transaction.total_price'),
            'transaction.status',
            AllowedFilter::exact('transaction.created_at'),
            AllowedFilter::exact('transaction.updated_at'),
        ];
    }

    /**
     * Get a list of allowed relationships that can be used in any include operations.
     *
     * @return string[]
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'productTransactions',
            'carts',
            'ratings',
            'users',
        ];
    }

    /**
     * Get a list of allowed searchable columns which can be used in any search operations.
     *
     * @return string[]
     */
    protected function getAllowedSearch(): array
    {
        return [
            'label',
            'detail',
            'category',
            'image',
            'transaction.status',
        ];
    }

    /**
     * Get a list of allowed columns that can be used in any sort operations.
     *
     * @return string[]
     */
    protected function getAllowedSorts(): array
    {
        return [
            'id',
            'label',
            'qty',
            'price',
            'size',
            'detail',
            'category',
            'image',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }

    /**
     * Get the default sort column that will be used in any sort operation.
     *
     * @return string
     */
    protected function getDefaultSort(): string
    {
        return 'id';
    }
}
