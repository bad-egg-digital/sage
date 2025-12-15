<?php

/**
 * Theme Blocks.
 */

namespace App\Blocks;

add_filter('block_type_metadata', function($metadata){
    $name = $metadata['name'];

    if (str_starts_with($name, 'core/') ) {
        unset($metadata['supports']['color']);
        unset($metadata['supports']['typography']);
    }

    return $metadata;
});

// Disable all core blocks except what we need as inner blocks
// resources/js/editor.js handles hiding the inner blocks at the top level
add_action('allowed_block_types_all', __NAMESPACE__ . '\\list_allowed', 100, 2);

// add blocks to the allowed list via filter
add_filter('badegg_block_types_allow', function($allowed){
    return array_merge($allowed, [
        // 'core/categories',
    ]);
});

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
        $json = json_decode(file_get_contents($block_json));
        $slug = basename(dirname($block_json));
        $blockPath = "resources/views/blocks/{$slug}";

        $viewScript = "{$blockPath}/view.js";
        $script = "{$blockPath}/script.js";
        $editorCSS = "{$blockPath}/editor.scss";
        $style = "{$blockPath}/style.scss";

        // editorStyle
        if (file_exists(get_theme_file_path($editorCSS))) {
            wp_register_style(
                "{$slug}-editor-style",
                \Vite::asset($editorCSS),
                [],
                null
            );
        }

        // script
        if(file_exists(get_theme_file_path($script))) {
            wp_register_script(
                "{$slug}-script",
                \Vite::asset($script),
                [],
                null,
                true
            );
        }

        // style
        if (file_exists(get_theme_file_path($style))) {
            wp_register_style(
                "{$slug}-style",
                \Vite::asset($style),
                [],
                null
            );
        }

        // viewScript
        if(file_exists(get_theme_file_path($viewScript))) {
            wp_register_script(
                "{$slug}-view-script",
                \Vite::asset($viewScript),
                [],
                null,
                true
            );
        }

        $props = [
            'editor_style'      => "{$slug}-editor-style",
            'style'             => "{$slug}-style",
            'script'            => "{$slug}-script",
            'view_script'       => "{$slug}-view-script",
        ];

        if(!property_exists($json, 'acf') && \Roots\view()->exists("blocks.{$slug}.render")) {
            $props['render_callback']   = function ($attributes, $content, $block) {
                $slug = basename($block->name);

                return \Roots\view("blocks.{$slug}.render", [
                    'attributes' => $attributes,
                    'content' => $content,
                    'block' => $block,
                ]);
            };
        }

        register_block_type($block_json, $props);
    }
});

function list_inner()
{
    $file = file_get_contents(get_theme_file_path("resources/json/core-block-whitelist.json"));
    $json = json_decode($file);

    return $json;
}

function list_all()
{
    $blocks = array_map(function($block) {
        $name = $block->name;

        return $block->name;

    }, \WP_Block_Type_Registry::get_instance()->get_all_registered());

    return array_values($blocks);
}

function list_custom()
{
    return array_filter(list_all(), function($value){
        if (str_starts_with($value, 'acf/') || str_starts_with($value, 'badegg/')) return $value;
    });
}

function list_allowed()
{
    $add_allowed = [];

    return array_merge(
        list_custom(),
        list_inner(),
        apply_filters('badegg_block_types_allow', $add_allowed),
    );
}

function render_acf($block, $content = '', $is_preview = false, $post_id = 0, $wp_block = false, $context = false) {
    $slug = basename($block['name']);
    $block['slug'] = $slug;

    $blade = \Roots\view(
        "blocks.{$slug}.render",
        [
            'block' => $block,
            'content' => $content,
            'is_preview' => $is_preview,
            'post_id' => $post_id,
            'wp_block' => $wp_block,
            'context' => $context,
        ],
    );

    if($blade) {
        echo $blade;
    } else {
        ob_start(); ?>

        <section class="section bg-error knockout">
            <div class="container container-small align-centre wysiwyg">
                <h2>Missing Blade Template</h2>
                <p>(resources/views/blocks/<?= $slug ?>/render.blade.php)</p>
            </div>
        </section>

        <?php echo ob_get_clean();
    }
}
