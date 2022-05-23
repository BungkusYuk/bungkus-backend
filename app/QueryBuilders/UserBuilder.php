<?php

namespace App\QueryBuilders;

use App\Http\Requests\UserGetRequest;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class UserBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var UserGetRequest
     */
    protected $request;

    /**
     * UserBuilder constructor.
     *
     * @param UserGetRequest $request
     */
    public function __construct(UserGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(User::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'users.id',
            'users.name',
            'users.email',
            'users.phone',
            'users.password',
            'users.remember_token',
            'users.created_at',
            'users.updated_at',
            'users.deleted_at',
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
            'name',
            'email',
            'phone',
            'password',
            'remember_token',
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('deleted_at'),
            AllowedFilter::exact('users.id'),
            'users.name',
            'users.email',
            'users.phone',
            'users.password',
            'users.remember_token',
            AllowedFilter::exact('users.created_at'),
            AllowedFilter::exact('users.updated_at'),
            AllowedFilter::exact('users.deleted_at'),
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
            'addresses',
            'carts',
            'ratings',
            'transactions',
            'products',
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
            'name',
            'email',
            'phone',
            'password',
            'remember_token',
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
            'name',
            'email',
            'phone',
            'password',
            'remember_token',
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
