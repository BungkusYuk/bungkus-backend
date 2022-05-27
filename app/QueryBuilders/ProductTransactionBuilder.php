<?php

namespace App\QueryBuilders;

use App\Http\Requests\ProductTransactionGetRequest;
use App\Models\ProductTransaction;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ProductTransactionBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var ProductTransactionGetRequest
     */
    protected $request;

    /**
     * ProductTransactionBuilder constructor.
     *
     * @param ProductTransactionGetRequest $request
     */
    public function __construct(ProductTransactionGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(ProductTransaction::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'product_transactions.id',
            'product_transactions.transaction_id',
            'product_transactions.product_id',
            'product_transactions.created_at',
            'product_transactions.updated_at',
            'transaction.id',
            'transaction.user_id',
            'transaction.qty_transaction',
            'transaction.subtotal_products',
            'transaction.total_price',
            'transaction.status',
            'transaction.created_at',
            'transaction.updated_at',
            'product.id',
            'product.label',
            'product.qty',
            'product.price',
            'product.size',
            'product.detail',
            'product.created_at',
            'product.updated_at',
            'product.deleted_at',
            'product.category',
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
            AllowedFilter::exact('transaction_id'),
            AllowedFilter::exact('product_id'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('product_transactions.id'),
            AllowedFilter::exact('product_transactions.transaction_id'),
            AllowedFilter::exact('product_transactions.product_id'),
            AllowedFilter::exact('product_transactions.created_at'),
            AllowedFilter::exact('product_transactions.updated_at'),
            AllowedFilter::exact('transaction.id'),
            AllowedFilter::exact('transaction.user_id'),
            AllowedFilter::exact('transaction.qty_transaction'),
            AllowedFilter::exact('transaction.subtotal_products'),
            AllowedFilter::exact('transaction.total_price'),
            'transaction.status',
            AllowedFilter::exact('transaction.created_at'),
            AllowedFilter::exact('transaction.updated_at'),
            AllowedFilter::exact('product.id'),
            'product.label',
            AllowedFilter::exact('product.qty'),
            AllowedFilter::exact('product.price'),
            AllowedFilter::exact('product.size'),
            'product.detail',
            AllowedFilter::exact('product.created_at'),
            AllowedFilter::exact('product.updated_at'),
            AllowedFilter::exact('product.deleted_at'),
            'product.category',
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
            'transaction',
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
            'transaction.status',
            'product.label',
            'product.detail',
            'product.category',
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
            'transaction_id',
            'product_id',
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
}
