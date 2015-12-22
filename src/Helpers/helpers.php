<?php

if ( ! function_exists('tenant')) {
    /**
     * Get the current tenant.
     *
     * @return array|null
     */
    function tenant()
    {
        static $tenant;

        if(is_null($tenant)) {
            $tenant = app('Tenant');
        }

        return $tenant;
    }

}

if ( ! function_exists('tenant_path')) {
    /**
     * Get the path to the given tenant directory.
     *
     * @param  int|array $tenant
     * @param  string $affix
     * @return string
     */
    function tenant_path($tenant, $affix = '')
    {
        $path = config('tenant.path') . '/';

        is_array($tenant) && array_key_exists('id', $tenant) ?
            $path .= $tenant['id'] :
            $path .= $tenant;

        return $path . $affix;
    }
}

if ( ! function_exists('tasset')) {
    /**
     * Get the route to retrieve the given tenant asset.
     *
     * @param  string $path
     * @return string
     */
    function tasset($path)
    {
        if( tenant() ) {
            return route('asset', [$path]);
        }

        return asset($path);
    }
}