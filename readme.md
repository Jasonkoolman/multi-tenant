# multi-tenant
A simple and lightweight package to craft multi-tenant applications with Laravel.

#### Defining tenants
Tenants are defined in `config/tenant.php`. Make sure to run the `php artisan vendor:publish` command to have this file created. By default, the tenant directories are located at `storage/tenants/{tenantID}`. If you want to use a different base path, override the `path` array key.
   
    return [
        'path' => storage_path('tenants'),
        
        'hosts' => [
            'mysite.com' => [
                'id'    => 'mysite',
                'name'  => 'MySite',
                'https' => true,
            ],
            'anothersite.com' => [
                'id'    => 'anothersite',
                'name'  => 'AnotherSite',
                'https' => false,
                'foo' => 'bar',
            ]
        ]
    ]
    
In some cases you might want to add custom tenant-specific parameters, like an API key, for instance. Simply use the helper function to retrieve a tenant-specific key value: `tenant('foo')`.

#### Eloquent models
In order for your models to deal with multiple connections, simply extend the `TenantModel` class or implement the `HasTenancy` trait. Both classes do exactly the same. Choose the approach you prefer.

#### Migrating and seeding
Each tenant has it's own database, which you will want to migrate and seed every once in a while. Define your tenant connections within `config/database.php` and simply add the `--database` parameter to tell artisan which database to choose, for example:

    php artisan migrate:refresh  --database {tenantConnection} --seed