<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTransactionSaveRequest;
use App\Http\Resources\ProductTransactionCollection;
use App\Http\Resources\ProductTransactionResource;
use App\Models\ProductTransaction;
use App\QueryBuilders\ProductTransactionBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Product Transaction Management
 *
 * API Endpoints for managing product transactions.
 */
class ProductTransactionsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * ProductTransactionsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(ProductTransaction::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the product transaction resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[product_transactions] *string* - No-example
     * Comma-separated field/attribute names of the product_transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `transaction_id`, `product_id`, `created_at`, `updated_at`.
     * @queryParam fields[transaction] *string* - No-example
     * Comma-separated field/attribute names of the transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`.
     * @queryParam fields[product] *string* - No-example
     * Comma-separated field/attribute names of the product resource to include in the response document.
     * The available fields for current endpoint are: `id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`, `category`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `transaction`, `product`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `transaction_id`, `product_id`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `transaction_id`, `product_id`, `created_at`, `updated_at`, `transaction.id`, `transaction.user_id`, `transaction.qty_transaction`, `transaction.subtotal_products`, `transaction.total_price`, `transaction.status`, `transaction.created_at`, `transaction.updated_at`, `product.id`, `product.label`, `product.qty`, `product.price`, `product.size`, `product.detail`, `product.created_at`, `product.updated_at`, `product.deleted_at`, `product.category`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\ProductTransactionBuilder $query
     *
     * @return ProductTransactionCollection
     */
    public function index(ProductTransactionBuilder $query): ProductTransactionCollection
    {
        return new ProductTransactionCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new product transaction resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\ProductTransactionSaveRequest $request
     * @param \App\Models\ProductTransaction $productTransaction
     *
     * @return JsonResponse
     */
    public function store(ProductTransactionSaveRequest $request, ProductTransaction $productTransaction): JsonResponse
    {
        $productTransaction->fill($request->only($productTransaction->offsetGet('fillable')))
            ->save();

        $resource = (new ProductTransactionResource($productTransaction))
            ->additional(['info' => 'The new product transaction has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific product transaction resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam productTransaction required *integer* - No-example
     * The identifier of a specific product transaction resource.
     *
     * @queryParam fields[product_transactions] *string* - No-example
     * Comma-separated field/attribute names of the product_transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `transaction_id`, `product_id`, `created_at`, `updated_at`.
     * @queryParam fields[transaction] *string* - No-example
     * Comma-separated field/attribute names of the transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`.
     * @queryParam fields[product] *string* - No-example
     * Comma-separated field/attribute names of the product resource to include in the response document.
     * The available fields for current endpoint are: `id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`, `category`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `transaction`, `product`.
     *
     * @param \App\QueryBuilders\ProductTransactionBuilder $query
     * @param \App\Models\ProductTransaction $productTransaction
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return ProductTransactionResource
     */
    public function show(ProductTransactionBuilder $query, ProductTransaction $productTransaction): ProductTransactionResource
    {
        return new ProductTransactionResource($query->find($productTransaction->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific product transaction resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam productTransaction required *integer* - No-example
     * The identifier of a specific product transaction resource.
     *
     * @param \App\Http\Requests\ProductTransactionSaveRequest $request
     * @param \App\Models\ProductTransaction $productTransaction
     *
     * @return ProductTransactionResource
     */
    public function update(ProductTransactionSaveRequest $request, ProductTransaction $productTransaction): ProductTransactionResource
    {
        $productTransaction->fill($request->only($productTransaction->offsetGet('fillable')));

        if ($productTransaction->isDirty()) {
            $productTransaction->save();
        }

        return (new ProductTransactionResource($productTransaction))
            ->additional(['info' => 'The product transaction has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific product transaction resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam productTransaction required *integer* - No-example
     * The identifier of a specific product transaction resource.
     *
     * @param \App\Models\ProductTransaction $productTransaction
     *
     * @throws \Exception
     *
     * @return ProductTransactionResource
     */
    public function destroy(ProductTransaction $productTransaction): ProductTransactionResource
    {
        $productTransaction->delete();

        return (new ProductTransactionResource($productTransaction))
            ->additional(['info' => 'The product transaction has been deleted.']);
    }
}
