<?php

namespace App\Admin;
use ourcodeworld\NameThatColor\ColorInterpreter as NameThatColor;
use App\Utilities;

class Theme
{
    public function __construct()
    {
        add_action( 'after_setup_theme', [$this, 'initialise'] );
        add_action( 'after_setup_theme', [$this, 'DynamicPalette'] );
    }

    public function initialise()
    {
       /*
        * Default Posts
        */
        $defaultPostID = 1;
        $defaultPost = get_post($defaultPostID);

        if($defaultPost->post_name == 'hello-world') {
            $defaultPost->post_status = 'trash';
            wp_update_post($defaultPost);
        }

        $defaultPageID = 2;
        $defaultPage = get_post($defaultPageID);

        if($defaultPage->post_name == 'sample-page') {
            $defaultPage->post_title = 'Home';
            $defaultPage->post_name = 'home';
            $defaultPage->menu_order = -100;
            $defaultPage->post_content = '';

            wp_update_post($defaultPage);
            update_option('show_on_front', 'page');
            update_option('page_on_front', $defaultPageID);
        }

       /*
        * Media Settings
        */

        if(get_option('thumbnail_size_w') == 150) {
            update_option('thumbnail_size_w', 300);
            update_option('thumbnail_size_h', 300);
        }

        if(get_option('medium_size_w') == 300) {
            update_option('medium_size_w', 1000);
            update_option('medium_size_h', 1000);
        }

        if(get_option('large_size_w') == 1024) {
            update_option('large_size_w', 1600);
            update_option('large_size_h', 1600);
        }

       /*
        * Set permalink structure
        */
        if(!get_option('permalink_structure')) {
            update_option('permalink_structure', '/%postname%/');

            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }
    }

    public function DynamicPalette()
    {
        $colour = new Utilities\Colour;
        $NameThatColour = new NameThatColor;

        $palette = [];

        $colours = $colour->values();

        foreach($colours as $slug => $hex) {
            $palette[] = [
                'name' => esc_html__(@$NameThatColour->name($hex)['name'], 'badegg'),
                'slug' => $slug,
                'color' => $hex,
            ];
        }

        if(!empty($colours)) {
            add_theme_support('editor-color-palette', $palette);
        }
    }
}
