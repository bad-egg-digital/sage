<?php

namespace App\PostTypes;

class Social
{
    public function __construct()
    {
        add_action('init', [$this, 'register']);
    }

    public function register()
    {
        $td = 'sage';
        $postType = 'social';

        register_extended_post_type(
            $postType,
            [
                'menu_position' => 28,
                'supports' => [
                    'title',
                    'page-attributes',
                ],
                'menu_icon' => 'dashicons-share',
                'rewrite' => false,
                'has_archive' => false,
                'publicly_queryable' => false,
                'exclude_from_search' => true,
                'capability_type' => 'page',
                'show_in_nav_menus' => false,
                'admin_cols' => [
                    'social_link' => [
                        'title' => __('Social Link', $td),
                        'meta_key' => 'fontawesome_brands',
                        'function' => function(){
                            $icon = get_field('fontawesome_brands');
                            $url = get_field('url');

                            if($icon): ?>

                                <a
                                    href="<?= $url ?: '#' ?>"
                                    class="fa-brands fa-<?= $icon ?>"
                                    rel="nofollow noindex"
                                    style="font-size: 2em;"
                                ></a>

                            <?php endif;

                        },
                    ],
                ],
            ],
        );
    }
}
