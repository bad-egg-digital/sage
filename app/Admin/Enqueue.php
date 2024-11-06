<?php

namespace App\Admin;

class Enqueue
{
    public function __construct()
    {
        add_action( 'admin_enqueue_scripts',  [$this, 'fontawesome']);
    }

    public function fontawesome()
    {
        wp_enqueue_style(
            'fontawesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
            false,
            '6.5.2',
            'all'
        );
    }
}
