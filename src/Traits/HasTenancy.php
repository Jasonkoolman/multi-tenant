<?php

namespace Kwalit\MultiTenant\Traits;

trait HasTenancy
{
    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        $tenant = tenant();

        if(is_null($tenant)) {
            return parent::getConnectionName();
        }

        return $tenant['id'];
    }
}