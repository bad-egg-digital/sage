<?php

namespace App\ACF;

class JSON
{
    public function __construct()
    {
        add_filter('acf/settings/save_json', [$this, 'save']);
        add_filter('acf/settings/load_json', [$this, 'load']);
    }

    public function save( $path )
    {
        $path = get_stylesheet_directory() . '/acf-json';
        return $path;
    }

    public function load( $paths )
    {
        unset($paths[0]);
        $paths[] = get_stylesheet_directory() . '/acf-json';
        return $paths;
    }
}
