<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionSaveRequest;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\TransactionResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Rating;
use App\Models\Transaction;
use App\QueryBuilders\TransactionBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Transaction Management
 *
 * API Endpoints for managing transactions.
 */
class TransactionsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * TransactionsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Transaction::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the transaction resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[transactions] *string* - No-example
     * Comma-separated field/attribute names of the transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`.
     * @queryParam fields[user] *string* - No-example
     * Comma-separated field/attribute names of the user resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `email`, `phone`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `user`, `products`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`, `user.id`, `user.name`, `user.email`, `user.phone`, `user.password`, `user.remember_token`, `user.created_at`, `user.updated_at`, `user.deleted_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\TransactionBuilder $query
     *
     * @return TransactionCollection
     */
    public function index(TransactionBuilder $query): TransactionCollection
    {
        return new TransactionCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new transaction resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\TransactionSaveRequest $request
     * @param \App\Models\Transaction $transaction
     *
     * @return JsonResponse
     */
    public function store(TransactionSaveRequest $request, Transaction $transaction): JsonResponse
    {
        $request['status'] = 'inprogress';
        $request['invoice_number'] = 'INV'.now()->format('isu');

        foreach ($request['product_transactions'] ?: [] as $item) {
            $product = Product::where('id',$item['product_id'])->firstOrFail();
            if ($item['qty']>$product['qty']) {
                abort(422, $item['product_id'].', Out of stock');
            }
            $product->decrement('qty',$item['qty']);
        }

        $transaction->fill($request->only($transaction->offsetGet('fillable')))
            ->save();

        foreach ($request['product_transactions'] ?: [] as $item) {
            $productTransaction = new ProductTransaction;
            $item['transaction_id'] = $transaction->id;
            $item['product_qty'] = $item['qty'];
            
            $productTransaction->fill($item)->save();

            Cart::where('user_id',auth()->user()?->id)->where('product_id',$item['product_id'])->firstOrFail()->delete();
        }

        $resource = (new TransactionResource($transaction))
            ->additional(['info' => 'The new transaction has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific transaction resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam transaction required *integer* - No-example
     * The identifier of a specific transaction resource.
     *
     * @queryParam fields[transactions] *string* - No-example
     * Comma-separated field/attribute names of the transaction resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `qty_transaction`, `subtotal_products`, `total_price`, `status`, `created_at`, `updated_at`.
     * @queryParam fields[user] *string* - No-example
     * Comma-separated field/attribute names of the user resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `email`, `phone`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `user`, `products`.
     *
     * @param \App\QueryBuilders\TransactionBuilder $query
     * @param \App\Models\Transaction $transaction
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return TransactionResource
     */
    public function show(TransactionBuilder $query, Transaction $transaction): TransactionResource
    {
        return new TransactionResource($query->find($transaction->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific transaction resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam transaction required *integer* - No-example
     * The identifier of a specific transaction resource.
     *
     * @param \App\Http\Requests\TransactionSaveRequest $request
     * @param \App\Models\Transaction $transaction
     *
     * @return TransactionResource
     */
    public function update(TransactionSaveRequest $request, Transaction $transaction): TransactionResource
    {
        if ($transaction['status']=='complete') {
            abort(422, 'is not inprogress');
        }
        $request['status'] = 'complete';

        $transaction->fill($request->only($transaction->offsetGet('fillable')));

        if ($transaction->isDirty()) {
            $transaction->save();
        }

        foreach ($request['product_transactions'] ?: [] as $item) {
            $rating = new Rating;
            $rating->fill([
                'user_id' => auth()->user()?->id,
                'product_id' => $item['product_id'],
                'transaction_id' => $transaction->id,
                'rating' => 0,
                'is_rating' => false,
            ])->save();
        }

        return (new TransactionResource($transaction))
            ->additional(['info' => 'The transaction has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific transaction resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam transaction required *integer* - No-example
     * The identifier of a specific transaction resource.
     *
     * @param \App\Models\Transaction $transaction
     *
     * @throws \Exception
     *
     * @return TransactionResource
     */
    public function destroy(Transaction $transaction): TransactionResource
    {
        $transaction->delete();

        return (new TransactionResource($transaction))
            ->additional(['info' => 'The transaction has been deleted.']);
    }
}
