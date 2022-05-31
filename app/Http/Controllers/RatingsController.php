<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingSaveRequest;
use App\Http\Resources\RatingCollection;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\QueryBuilders\RatingBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Rating Management
 *
 * API Endpoints for managing ratings.
 */
class RatingsController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * RatingsController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Rating::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the rating resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[ratings] *string* - No-example
     * Comma-separated field/attribute names of the rating resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `product_id`, `rating`, `is_rating`, `created_at`, `updated_at`.
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
     * The available fields for sorting operation in current endpoint are: `id`, `user_id`, `product_id`, `rating`, `is_rating`, `created_at`, `updated_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `user_id`, `product_id`, `rating`, `is_rating`, `created_at`, `updated_at`, `user.id`, `user.name`, `user.email`, `user.phone`, `user.password`, `user.remember_token`, `user.created_at`, `user.updated_at`, `user.deleted_at`, `product.id`, `product.transaction_id`, `product.label`, `product.qty`, `product.price`, `product.size`, `product.detail`, `product.created_at`, `product.updated_at`, `product.deleted_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\RatingBuilder $query
     *
     * @return RatingCollection
     */
    public function index(RatingBuilder $query): RatingCollection
    {
        return new RatingCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new rating resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\RatingSaveRequest $request
     * @param \App\Models\Rating $rating
     *
     * @return JsonResponse
     */
    public function store(RatingSaveRequest $request, Rating $rating): JsonResponse
    {
        $rating->fill($request->only($rating->offsetGet('fillable')))
            ->save();

        $resource = (new RatingResource($rating))
            ->additional(['info' => 'The new rating has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific rating resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam rating required *integer* - No-example
     * The identifier of a specific rating resource.
     *
     * @queryParam fields[ratings] *string* - No-example
     * Comma-separated field/attribute names of the rating resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `product_id`, `rating`, `is_rating`, `created_at`, `updated_at`.
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
     * @param \App\QueryBuilders\RatingBuilder $query
     * @param \App\Models\Rating $rating
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return RatingResource
     */
    public function show(RatingBuilder $query, Rating $rating): RatingResource
    {
        return new RatingResource($query->find($rating->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific rating resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam rating required *integer* - No-example
     * The identifier of a specific rating resource.
     *
     * @param \App\Http\Requests\RatingSaveRequest $request
     * @param \App\Models\Rating $rating
     *
     * @return RatingResource
     */
    public function update(RatingSaveRequest $request, Rating $rating): RatingResource
    {
        $request['is_rating'] = 1;
        $rating->fill($request->only($rating->offsetGet('fillable')));

        if ($rating->isDirty()) {
            $rating->save();
        }

        return (new RatingResource($rating))
            ->additional(['info' => 'The rating has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific rating resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam rating required *integer* - No-example
     * The identifier of a specific rating resource.
     *
     * @param \App\Models\Rating $rating
     *
     * @throws \Exception
     *
     * @return RatingResource
     */
    public function destroy(Rating $rating): RatingResource
    {
        $rating->delete();

        return (new RatingResource($rating))
            ->additional(['info' => 'The rating has been deleted.']);
    }
}
