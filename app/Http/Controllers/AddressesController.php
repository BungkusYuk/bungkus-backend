<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressSaveRequest;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\QueryBuilders\AddressBuilder;
use Illuminate\Http\JsonResponse;

/**
 * @group Address Management
 *
 * API Endpoints for managing addresses.
 */
class AddressesController extends Controller
{
    /**
     * Determine if any access to this resource require authorization.
     *
     * @var bool
     */
    protected static $requireAuthorization = false;

    /**
     * AddressesController constructor.
     */
    public function __construct()
    {
        if (self::$requireAuthorization || (auth()->user() !== null)) {
            $this->authorizeResource(Address::class);
        }
    }

    /**
     * Resource Collection.
     * Display a collection of the address resources in paginated document format.
     *
     * @authenticated
     *
     * @queryParam fields[addresses] *string* - No-example
     * Comma-separated field/attribute names of the address resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `street`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam fields[user] *string* - No-example
     * Comma-separated field/attribute names of the user resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `email`, `phone`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam page[size] *integer* - No-example
     * Describe how many records to display in a collection.
     * @queryParam page[number] *integer* - No-example
     * Describe the number of current page to display.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `user`.
     * @queryParam sort *string* - No-example
     * Field/attribute to sort the resources in response document by.
     * The available fields for sorting operation in current endpoint are: `id`, `user_id`, `street`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam filter[`filterName`] *string* - No-example
     * Filter the resources by specifying *attribute name* or *query scope name*.
     * The available filters for current endpoint are: `id`, `user_id`, `street`, `created_at`, `updated_at`, `deleted_at`, `user.id`, `user.name`, `user.email`, `user.phone`, `user.password`, `user.remember_token`, `user.created_at`, `user.updated_at`, `user.deleted_at`.
     * @qeuryParam search *string* - No-example
     * Filter the resources by specifying any keyword to search.
     *
     * @param \App\QueryBuilders\AddressBuilder $query
     *
     * @return AddressCollection
     */
    public function index(AddressBuilder $query): AddressCollection
    {
        return new AddressCollection($query->paginate());
    }

    /**
     * Create Resource.
     * Create a new address resource.
     *
     * @authenticated
     *
     * @param \App\Http\Requests\AddressSaveRequest $request
     * @param \App\Models\Address $address
     *
     * @return JsonResponse
     */
    public function store(AddressSaveRequest $request, Address $address): JsonResponse
    {
        $address->fill($request->only($address->offsetGet('fillable')))
            ->save();

        $resource = (new AddressResource($address))
            ->additional(['info' => 'The new address has been saved.']);

        return $resource->toResponse($request)->setStatusCode(201);
    }

    /**
     * Show Resource.
     * Display a specific address resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam address required *integer* - No-example
     * The identifier of a specific address resource.
     *
     * @queryParam fields[addresses] *string* - No-example
     * Comma-separated field/attribute names of the address resource to include in the response document.
     * The available fields for current endpoint are: `id`, `user_id`, `street`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam fields[user] *string* - No-example
     * Comma-separated field/attribute names of the user resource to include in the response document.
     * The available fields for current endpoint are: `id`, `name`, `email`, `phone`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`.
     * @queryParam include *string* - No-example
     * Comma-separated relationship names to include in the response document.
     * The available relationships for current endpoint are: `user`.
     *
     * @param \App\QueryBuilders\AddressBuilder $query
     * @param \App\Models\Address $address
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return AddressResource
     */
    public function show(AddressBuilder $query, Address $address): AddressResource
    {
        return new AddressResource($query->find($address->getKey()));
    }

    /**
     * Update Resource.
     * Update a specific address resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam address required *integer* - No-example
     * The identifier of a specific address resource.
     *
     * @param \App\Http\Requests\AddressSaveRequest $request
     * @param \App\Models\Address $address
     *
     * @return AddressResource
     */
    public function update(AddressSaveRequest $request, Address $address): AddressResource
    {
        $address->fill($request->only($address->offsetGet('fillable')));

        if ($address->isDirty()) {
            $address->save();
        }

        return (new AddressResource($address))
            ->additional(['info' => 'The address has been updated.']);
    }

    /**
     * Delete Resource.
     * Delete a specific address resource identified by the given id/key.
     *
     * @authenticated
     *
     * @urlParam address required *integer* - No-example
     * The identifier of a specific address resource.
     *
     * @param \App\Models\Address $address
     *
     * @throws \Exception
     *
     * @return AddressResource
     */
    public function destroy(Address $address): AddressResource
    {
        $address->delete();

        return (new AddressResource($address))
            ->additional(['info' => 'The address has been deleted.']);
    }
}
