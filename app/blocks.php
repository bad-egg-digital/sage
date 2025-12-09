<?php

/**
 * Theme Blocks.
 */

namespace App;

add_filter( 'block_categories_all' , function ( $categories ) {

        // Adding a new category.
        $categories = array_merge([
            [
                'slug'  => 'badegg',
                'title' => __('Provided by Bad Egg Digital'),
            ],
        ], $categories);

        return $categories;
});

add_action('allowed_block_types_all', function(){
    $blocks = block_all();
    $blacklist = array_diff($blocks, block_whitelist());

    return array_values( array_diff( $blocks, $blacklist ) );
}, 100, 2);

function block_whitelist()
{
    $file = file_get_contents(get_theme_file_path("resources/json/core-block-whitelist.json"));
    $json = json_decode($file);

    return $json;
}

function block_all()
{
    $enabled_blocks = array_map(function($block) {
        $name = $block->name;

        return $block->name;

    }, \WP_Block_Type_Registry::get_instance()->get_all_registered());

    return array_values($enabled_blocks);
}

add_action('wp_footer', function(){
    echo '<pre>',print_r(block_all()),'</pre>';
});
