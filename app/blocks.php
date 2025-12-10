<?php

/**
 * Theme Blocks.
 */

namespace App;

// Add the badegg block category
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

// Auto register WP blocks
add_action('init', function () {
    $blocks = glob(get_theme_file_path('resources/views/blocks/*/block.json'));

    foreach ($blocks as $block_json) {
        $slug = basename(dirname($block_json));

        // Editor JS
        $editor_js_path = "resources/views/blocks/{$slug}/index.jsx";
        if (file_exists(get_theme_file_path($editor_js_path))) {
            wp_register_script(
                "{$slug}-editor-script",
                \Vite::asset($editor_js_path),
                ['wp-blocks', 'wp-element', 'wp-editor'],
                null,
                true
            );
        }

        // Editor SCSS (compiled to CSS)
        $editor_css_path = "resources/views/blocks/{$slug}/editor.scss";
        if (file_exists(get_theme_file_path($editor_css_path))) {
            wp_register_style(
                "{$slug}-editor-style",
                \Vite::asset($editor_css_path),
                [],
                null
            );
        }

        // Frontend SCSS (compiled to CSS)
        $style_css_path = "resources/views/blocks/{$slug}/style.scss";
        if (file_exists(get_theme_file_path($style_css_path))) {
            wp_register_style(
                "{$slug}-style",
                \Vite::asset($style_css_path),
                [],
                null
            );
        }

        register_block_type($block_json, [
            'editor_script' => "{$slug}-editor-script",
            'editor_style'  => "{$slug}-editor-style",
            'style'         => "{$slug}-style",
            'render_callback' => function ($attributes, $content, $block) {
                $slug = basename($block->name);
                $view = "blocks.{$slug}.render";

                if (\Roots\view()->exists($view)) {
                    return \Roots\view($view, [
                        'attributes' => $attributes,
                        'content' => $content,
                        'block' => $block,
                    ]);
                }

                return $content;
            }
        ]);
    }
});

// Disable most of the core blocks
add_action('allowed_block_types_all', function(){
    $blocks = array_keys( \WP_Block_Type_Registry::get_instance()->get_all_registered() );
    $blacklist = array_diff(block_blacklist(), block_whitelist());

    return array_values( array_diff( $blocks, $blacklist ) );
}, 100, 2);

function block_blacklist()
{
    $file = file_get_contents(get_theme_file_path("resources/json/core-block-blacklist.json"));
    $json = json_decode($file);

    return $json;
}

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
