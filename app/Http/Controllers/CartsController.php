<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartSaveRequest;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\QueryBuilders\CartBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * @group Cart Management
 *
 * API Endpoints for managing carts.
 */
class CartsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * CartsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Cart::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the cart resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[carts] *string* - No-example
     * Comma-separated field/attribute names of the cart resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `product_id`, `product_qty`, `created_at`, `updated_at`.
     * @queryParam fields[user] *string* - No-example
     * Comma-separated field/attribute names of the user resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `email`, `phone`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam fields[product] *string* - No-example
     * Comma-separated field/attribute names of the product resource to include in the response document.
     * The available fields for current endpoint are: `id`, `transaction_id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `user`, `product`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `user_id`, `product_id`, `product_qty`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `user_id`, `product_id`, `product_qty`, `created_at`, `updated_at`, `user.id`, `user.name`, `user.email`, `user.phone`, `user.password`, `user.remember_token`, `user.created_at`, `user.updated_at`, `user.deleted_at`, `product.id`, `product.transaction_id`, `product.label`, `product.qty`, `product.price`, `product.size`, `product.detail`, `product.created_at`, `product.updated_at`, `product.deleted_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\CartBuilder $query
     *
     * @return CartCollection
     */
    public function index(CartBuilder $query): CartCollection
    {
        return new CartCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new cart resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\CartSaveRequest $request
     * @param \App\Models\Cart $cart
     *
     * @return JsonResponse
     */
    public function store(CartSaveRequest $request, Cart $cart): JsonResponse
    {
        $product = Product::where('id',$request['product_id'])->firstOrFail();
        if ($request['product_qty']>$product['qty']) {
            abort(422, 'Out of stock');
        }

        $cart->fill($request->only($cart->offsetGet('fillable')))
            ->save();

        $resource = (new CartResource($cart))
            ->additional(['info' => 'The new cart has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific cart resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam cart required *integer* - No-example
     * The identifier of a specific cart resource.
     *
     * @queryParam fields[carts] *string* - No-example
     * Comma-separated field/attribute names of the cart resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `product_id`, `product_qty`, `created_at`, `updated_at`.
     * @queryParam fields[user] *string* - No-example
     * Comma-separated field/attribute names of the user resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `email`, `phone`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam fields[product] *string* - No-example
     * Comma-separated field/attribute names of the product resource to include in the response document.
     * The available fields for current endpoint are: `id`, `transaction_id`, `label`, `qty`, `price`, `size`, `detail`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `user`, `product`.
     *
     * @param \App\QueryBuilders\CartBuilder $query
     * @param \App\Models\Cart $cart
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return CartResource
     */
    public function show(CartBuilder $query, Cart $cart): CartResource
    {
        return new CartResource($query->find($cart->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific cart resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam cart required *integer* - No-example
     * The identifier of a specific cart resource.
     *
     * @param \App\Http\Requests\CartSaveRequest $request
     * @param \App\Models\Cart $cart
     *
     * @return CartResource
     */
    public function update(CartSaveRequest $request, Cart $cart): CartResource
    {
        $product = Product::where('id',$request['product_id'])->firstOrFail();
        if ($request['product_qty']>$product['qty']) {
            abort(422, 'Out of stock');
        }

        $cart->fill($request->only($cart->offsetGet('fillable')));

        if ($cart->isDirty()) {
            $cart->save();
        }

        return (new CartResource($cart))
            ->additional(['info' => 'The cart has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific cart resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam cart required *integer* - No-example
     * The identifier of a specific cart resource.
     *
     * @param \App\Models\Cart $cart
     *
     * @throws \Exception
     *
     * @return CartResource
     */
    public function destroy(Cart $cart): CartResource
    {
        $cart->delete();

        return (new CartResource($cart))
            ->additional(['info' => 'The cart has been deleted.']);
    }

    public function details(Request $request): Response
    {
        $request->validate([
            'shipping_cost' => 'required|integer|between:0,2147483647',
        ]);

        $productCart = auth()->user()->carts;
        $subTotal=0;
        foreach ($productCart as $item) {
            $subTotal += $item['product_qty']*$item['price'];
        }
        $response = [
            'subtotal_products' => $subTotal,
            'shipping_cost' => $request['shipping_cost'],
            'total_price' => $subTotal+$request['shipping_cost'],
        ];

        return response($response, 200);
    }
}
