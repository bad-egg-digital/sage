<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Socials extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'components.socials',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'socials' => get_posts([
                'post_type' => 'social',
                'order' => 'ASC',
                'orderby' => 'menu_order name',
                'posts_per_page' => -1,
                'fields' => 'ids',
            ]),
        ];
    }
}
