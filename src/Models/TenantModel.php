<?php

namespace Kwalit\MultiTenant\Models;

use Illuminate\Database\Eloquent\Model;
use Kwalit\MultiTenant\Exceptions\TenantDatabaseNotFoundException;

class TenantModel extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->connection = $this->getConnectionName();

        parent::__construct($attributes);
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        $tenant = app()->make('Tenant');

        if($tenant) {
            return is_null(config('database.connections.' . $tenant['id'])) ?
                new TenantDatabaseNotFoundException() :
                array_get($tenant, 'id');
        }

        return parent::getConnectionName();
    }
}