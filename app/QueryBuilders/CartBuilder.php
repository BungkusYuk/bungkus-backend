<?php

namespace App\QueryBuilders;

use App\Http\Requests\CartGetRequest;
use App\Models\Cart;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

final class CartBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var CartGetRequest
     */
    protected $request;

    /**
     * CartBuilder constructor.
     *
     * @param CartGetRequest $request
     */
    public function __construct(CartGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Cart::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'carts.id',
            'carts.user_id',
            'carts.product_id',
            'carts.product_qty',
            'carts.created_at',
            'carts.updated_at',
            'user.id',
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            'user.created_at',
            'user.updated_at',
            'user.deleted_at',
            'product.id',
            'product.transaction_id',
            'product.label',
            'product.qty',
            'product.price',
            'product.size',
            'product.detail',
            'product.created_at',
            'product.updated_at',
            'product.deleted_at',
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
            AllowedFilter::exact('user_id'),
            AllowedFilter::exact('product_id'),
            AllowedFilter::exact('product_qty'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('carts.id'),
            AllowedFilter::exact('carts.user_id'),
            AllowedFilter::exact('carts.product_id'),
            AllowedFilter::exact('carts.product_qty'),
            AllowedFilter::exact('carts.created_at'),
            AllowedFilter::exact('carts.updated_at'),
            AllowedFilter::exact('user.id'),
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            AllowedFilter::exact('user.created_at'),
            AllowedFilter::exact('user.updated_at'),
            AllowedFilter::exact('user.deleted_at'),
            AllowedFilter::exact('product.id'),
            AllowedFilter::exact('product.transaction_id'),
            'product.label',
            AllowedFilter::exact('product.qty'),
            AllowedFilter::exact('product.price'),
            AllowedFilter::exact('product.size'),
            'product.detail',
            AllowedFilter::exact('product.created_at'),
            AllowedFilter::exact('product.updated_at'),
            AllowedFilter::exact('product.deleted_at'),
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
            'user',
            'product',
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
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            'product.label',
            'product.detail',
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
            'user_id',
            'product_id',
            'product_qty',
            'created_at',
            'updated_at',
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

    public function paginate(): LengthAwarePaginator|Paginator
    {
        $query = $this->query();
        $query = $query->where('user_id',auth()->user()?->id);
        return $query->jsonPaginate();
    }
}
