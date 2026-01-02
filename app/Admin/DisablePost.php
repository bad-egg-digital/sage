<?php

namespace App\Admin;

class DisablePost
{
    public function __construct()
    {
        // add_filter('register_post_type_args', [$this, 'args'], 0, 2);
        // add_filter('register_taxonomy_args', [$this, 'args'], 0, 2);
    }

    public function args($args, $type)
    {
        $types = [
            'post',
            'post_tag',
            'category',
        ];

        if(in_array($type, $types)) {
            $args['public'] = false;
        }

        return $args;
    }
}
