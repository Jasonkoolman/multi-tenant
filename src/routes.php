<?php

/**
 * Load tenant assets outside the public folder with this route.
 */
Route::get('asset/{path}', ['as' => 'asset', function($path)
{
    $asset = tenant_path(tenant(), '/assets/' . $path);

    if( ! file_exists($asset) ) {
        abort(404);
    }

    $mime = File::mimeType($asset);

    if ($mime == 'text/plain' && File::extension($asset) == 'css') {
        $mime = 'text/css';
    }

    return response(file_get_contents($asset), 200, ['Content-Type' => $mime]);
}
])->where('path', '(.*)');