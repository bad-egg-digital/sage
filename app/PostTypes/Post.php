<?php

namespace App\PostTypes;

class Post
{
    public function __construct()
    {
        /*
         * Default Post Type Disable
         */
        add_filter( 'register_post_type_args', [$this, 'disable'], 0, 2);
        add_filter( 'register_taxonomy_args', [$this, 'disable'], 0, 2);
        add_action( 'init', [ $this, 'unregister_tax' ]);

        /*
         * Default Post Type Customisations
         */
        // add_filter( 'post_type_labels_post', [$this, 'labels']);
        // add_filter( 'register_post_post_type_args', [$this, 'args'], 10, 2 );
        // add_filter( 'pre_post_link', [$this, 'permalink'], 10, 3);
    }

    function disable($args, $type)
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

    function remove_default_post_type()
    {
        remove_menu_page('edit.php');
    }

    function remove_default_post_type_menu_bar($wp_admin_bar)
    {
        $wp_admin_bar->remove_node( 'new-post' );
    }

    function unregister_tax()
    {
        foreach(['post_tag', 'category'] as $tax) {
            unregister_taxonomy_for_object_type($tax, 'post');
        }
    }

    public function labels($labels)
    {
        $labels->singular_name = __('Article', 'badegg');
        $labels->name = __('Articles', 'badegg');
        $labels->menu_name = __('News', 'badegg');

        return $labels;
    }

    public function args($args, $postType)
    {
        $args['rewrite'] = ['slug' => $this->slug()];
        // $args['menu_icon'] = 'dashicons-welcome-widgets-menus';

        return $args;
    }

    public function permalink($permalink, $post, $leavename)
    {
        if (get_post_type($post) == 'post')
            return $this->slug() . $permalink;
        else
            return $permalink;
    }

    public function slug()
    {
        $page_for_posts = get_option('page_for_posts');

        if(!$page_for_posts) return;

        $slug_for_posts = get_post_field('post_name', $page_for_posts);

        return $slug_for_posts;
    }

}
