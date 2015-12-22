<?php

namespace Kwalit\MultiTenant\Models;

use Illuminate\Database\Eloquent\Model;

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
        $tenant = tenant();

        if($tenant) {
            return array_get($tenant, 'id');
        }

        return parent::getConnectionName();
    }
}