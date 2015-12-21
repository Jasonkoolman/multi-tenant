<?php

namespace Kwalit\MultiTenant;

use Request;
use Illuminate\Support\ServiceProvider;

class MultiTenantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register shared binding
        $this->app->singleton('Tenant', function ()
        {
            $tenants = config('tenant.hosts');
            $host = Request::server('HTTP_HOST');

            if(array_key_exists($host, $tenants)) {
                return $tenants[$host];
            }

            return null;
        });

        $tenant = $this->app->make('Tenant');
        $directory = tenant_path($tenant);

        if($tenant && is_dir($directory)) {
            // Load views from the current tenant directory
            $this->app['view']->addLocation($directory . '/views');

            // Load optional routes from the current tenant directory
            if(file_exists($directory . '/routes.php')) require_once $directory . '/routes.php';
        }

        // Load base views, these will be overridden by tenant views with the same name
        $this->app['view']->addLocation(realpath(base_path('resources/views')));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'tenant');
    }
}
