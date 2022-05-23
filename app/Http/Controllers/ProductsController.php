<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSaveRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\QueryBuilders\ProductBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Product Management
 *
 * API Endpoints for managing products.
 */
class ProductsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Product::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the product resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[products] *string* - No-example
     * Comma-separated field/attribute names of the product resource to include in the response document.
     * The available fields for current endpoint are: `id`, `transaction_id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam fields[transaction] *string* - No-example
     * Comma-separated field/attribute names of the transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `transaction`, `carts`, `ratings`, `users`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `transaction_id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `transaction_id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`, `transaction.id`, `transaction.user_id`, `transaction.qty_transaction`, `transaction.subtotal_products`, `transaction.total_price`, `transaction.status`, `transaction.created_at`, `transaction.updated_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\ProductBuilder $query
     *
     * @return ProductCollection
     */
    public function index(ProductBuilder $query): ProductCollection
    {
        return new ProductCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new product resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\ProductSaveRequest $request
     * @param \App\Models\Product $product
     *
     * @return JsonResponse
     */
    public function store(ProductSaveRequest $request, Product $product): JsonResponse
    {
        $product->fill($request->only($product->offsetGet('fillable')))
            ->save();

        $resource = (new ProductResource($product))
            ->additional(['info' => 'The new product has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific product resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam product required *integer* - No-example
     * The identifier of a specific product resource.
     *
     * @queryParam fields[products] *string* - No-example
     * Comma-separated field/attribute names of the product resource to include in the response document.
     * The available fields for current endpoint are: `id`, `transaction_id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam fields[transaction] *string* - No-example
     * Comma-separated field/attribute names of the transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `transaction`, `carts`, `ratings`, `users`.
     *
     * @param \App\QueryBuilders\ProductBuilder $query
     * @param \App\Models\Product $product
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return ProductResource
     */
    public function show(ProductBuilder $query, Product $product): ProductResource
    {
        return new ProductResource($query->find($product->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific product resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam product required *integer* - No-example
     * The identifier of a specific product resource.
     *
     * @param \App\Http\Requests\ProductSaveRequest $request
     * @param \App\Models\Product $product
     *
     * @return ProductResource
     */
    public function update(ProductSaveRequest $request, Product $product): ProductResource
    {
        $product->fill($request->only($product->offsetGet('fillable')));

        if ($product->isDirty()) {
            $product->save();
        }

        return (new ProductResource($product))
            ->additional(['info' => 'The product has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific product resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam product required *integer* - No-example
     * The identifier of a specific product resource.
     *
     * @param \App\Models\Product $product
     *
     * @throws \Exception
     *
     * @return ProductResource
     */
    public function destroy(Product $product): ProductResource
    {
        $product->delete();

        return (new ProductResource($product))
            ->additional(['info' => 'The product has been deleted.']);
    }
}
