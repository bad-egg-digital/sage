<?php

namespace App\ACF;

class Options
{
    public function __construct()
    {
        add_filter('acf/init', [$this, 'company']);
    }

    public function company()
    {
        acf_add_options_page([
            'page_title'    => __('Global Settings'),
            'menu_title'    => __('Global Settings'),
            'menu_slug'     => 'theme-global-settings',
            'capability'    => 'edit_others_posts',
            'redirect'      => false,
            'icon_url'     => 'dashicons-admin-site',
        ]);
    }
}
