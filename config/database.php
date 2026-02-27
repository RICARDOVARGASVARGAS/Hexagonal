<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'pgsql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        // ─────────────────────────────────────────────────────
        // Conexión base → schema public
        // Laravel usa este schema para sus propias tablas:
        // migrations, sessions, jobs, cache, etc.
        // ─────────────────────────────────────────────────────
        'pgsql' => [
            'driver'      => 'pgsql',
            'host'        => env('DB_HOST', '127.0.0.1'),
            'port'        => env('DB_PORT', '5432'),
            'database'    => env('DB_DATABASE', 'laravel'),
            'username'    => env('DB_USERNAME', 'postgres'),
            'password'    => env('DB_PASSWORD', ''),
            'charset'     => 'utf8',
            'search_path' => 'public',
            'sslmode'     => 'prefer',
        ],

        // ─────────────────────────────────────────────────────
        // Schema: academy → schools, students
        // ─────────────────────────────────────────────────────
        'academy' => [
            'driver'      => 'pgsql',
            'host'        => env('DB_HOST', '127.0.0.1'),
            'port'        => env('DB_PORT', '5432'),
            'database'    => env('DB_DATABASE', 'laravel'),
            'username'    => env('DB_USERNAME', 'postgres'),
            'password'    => env('DB_PASSWORD', ''),
            'charset'     => 'utf8',
            'search_path' => 'academy',
            'sslmode'     => 'prefer',
        ],

        // ─────────────────────────────────────────────────────
        // Schema: store → clients, products
        // ─────────────────────────────────────────────────────
        'store' => [
            'driver'      => 'pgsql',
            'host'        => env('DB_HOST', '127.0.0.1'),
            'port'        => env('DB_PORT', '5432'),
            'database'    => env('DB_DATABASE', 'laravel'),
            'username'    => env('DB_USERNAME', 'postgres'),
            'password'    => env('DB_PASSWORD', ''),
            'charset'     => 'utf8',
            'search_path' => 'store',
            'sslmode'     => 'prefer',
        ],

        //  'connections' => [

        // // ─────────────────────────────────────────────────
        // // PostgreSQL | DB: laravel | Schema: academy
        // // ─────────────────────────────────────────────────
        // 'pgsql_academy' => [
        //     'driver'      => 'pgsql',
        //     'host'        => env('PG_HOST', '127.0.0.1'),
        //     'port'        => env('PG_PORT', '5432'),
        //     'database'    => env('PG_DATABASE', 'laravel'),
        //     'username'    => env('PG_USERNAME', 'postgres'),
        //     'password'    => env('PG_PASSWORD', ''),
        //     'charset'     => 'utf8',
        //     'search_path' => 'academy',  // ← hardcodeado, no necesita env
        //     'sslmode'     => 'prefer',
        // ],

        // // ─────────────────────────────────────────────────
        // // PostgreSQL | DB: laravel | Schema: finance
        // // ─────────────────────────────────────────────────
        // 'pgsql_finance' => [
        //     'driver'      => 'pgsql',
        //     'host'        => env('PG_HOST', '127.0.0.1'),  // misma DB
        //     'port'        => env('PG_PORT', '5432'),
        //     'database'    => env('PG_DATABASE', 'laravel'),
        //     'username'    => env('PG_USERNAME', 'postgres'),
        //     'password'    => env('PG_PASSWORD', ''),
        //     'charset'     => 'utf8',
        //     'search_path' => 'finance', // ← diferente schema, misma DB
        //     'sslmode'     => 'prefer',
        // ],

        // // ─────────────────────────────────────────────────
        // // PostgreSQL | DB: otra_base | Schema: public
        // // ─────────────────────────────────────────────────
        // 'pgsql_external' => [
        //     'driver'      => 'pgsql',
        //     'host'        => env('PG_EXTERNAL_HOST', '127.0.0.1'),
        //     'port'        => env('PG_EXTERNAL_PORT', '5432'),
        //     'database'    => env('PG_EXTERNAL_DATABASE', ''),
        //     'username'    => env('PG_EXTERNAL_USERNAME', 'postgres'),
        //     'password'    => env('PG_EXTERNAL_PASSWORD', ''),
        //     'charset'     => 'utf8',
        //     'search_path' => 'public',
        //     'sslmode'     => 'prefer',
        // ],

        // // ─────────────────────────────────────────────────
        // // MySQL | DB: sistema_viejo
        // // ─────────────────────────────────────────────────
        // 'mysql_legacy' => [
        //     'driver'    => 'mysql',
        //     'host'      => env('MYSQL_HOST', '127.0.0.1'),
        //     'port'      => env('MYSQL_PORT', '3306'),
        //     'database'  => env('MYSQL_DATABASE', ''),
        //     'username'  => env('MYSQL_USERNAME', 'root'),
        //     'password'  => env('MYSQL_PASSWORD', ''),
        //     'charset'   => 'utf8mb4',
        //     'collation' => 'utf8mb4_unicode_ci',
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')) . '-database-'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
            'max_retries' => env('REDIS_MAX_RETRIES', 3),
            'backoff_algorithm' => env('REDIS_BACKOFF_ALGORITHM', 'decorrelated_jitter'),
            'backoff_base' => env('REDIS_BACKOFF_BASE', 100),
            'backoff_cap' => env('REDIS_BACKOFF_CAP', 1000),
        ],

    ],

];
