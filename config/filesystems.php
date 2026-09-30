<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    | Disk used for all admin image uploads (App\Support\Media).
    | Uses DigitalOcean Spaces when DO_SPACE is set, otherwise the local public disk.
    */
    'media' => env('MEDIA_DISK', env('DO_SPACE') ? 'spaces' : 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        // DigitalOcean Spaces (S3-compatible). Everything is stored under the TET/ folder.
        'spaces' => [
            'driver' => 's3',
            'key' => env('DO_ACCESS_KEY_ID'),
            'secret' => env('DO_SECRET_ACCESS_KEY'),
            'region' => env('DO_DEFAULT_REGION', 'sfo3'),
            'bucket' => env('DO_SPACE'),
            // DO_ENDPOINT may be the bucket URL (https://<space>.<region>.digitaloceanspaces.com);
            // the SDK needs the region endpoint (https://<region>.digitaloceanspaces.com).
            'endpoint' => env('DO_ENDPOINT')
                ? preg_replace('#^(https?://)' . preg_quote((string) env('DO_SPACE'), '#') . '\.#', '$1', rtrim(env('DO_ENDPOINT'), '/'))
                : null,
            'url' => rtrim((string) env('DO_CDN_ENDPOINT', env('DO_ENDPOINT')), '/'),
            'root' => env('DO_FOLDER', 'TET'),
            'visibility' => 'public',
            'use_path_style_endpoint' => false,
            'throw' => true,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
