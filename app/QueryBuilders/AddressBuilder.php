<?php

namespace App\QueryBuilders;

use App\Http\Requests\AddressGetRequest;
use App\Models\Address;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class AddressBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var AddressGetRequest
     */
    protected $request;

    /**
     * AddressBuilder constructor.
     *
     * @param AddressGetRequest $request
     */
    public function __construct(AddressGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Address::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'addresses.id',
            'addresses.user_id',
            'addresses.street',
            'addresses.city',
            'addresses.postal_code',
            'addresses.created_at',
            'addresses.updated_at',
            'addresses.deleted_at',
            'user.id',
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            'user.created_at',
            'user.updated_at',
            'user.deleted_at',
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
            'street',
            'city',
            'postal_code',
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('deleted_at'),
            AllowedFilter::exact('addresses.id'),
            AllowedFilter::exact('addresses.user_id'),
            'addresses.street',
            'addresses.city',
            'addresses.postal_code',
            AllowedFilter::exact('addresses.created_at'),
            AllowedFilter::exact('addresses.updated_at'),
            AllowedFilter::exact('addresses.deleted_at'),
            AllowedFilter::exact('user.id'),
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            AllowedFilter::exact('user.created_at'),
            AllowedFilter::exact('user.updated_at'),
            AllowedFilter::exact('user.deleted_at'),
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
            'street',
            'city',
            'postal_code',
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
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
            'street',
            'city',
            'postal_code',
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
