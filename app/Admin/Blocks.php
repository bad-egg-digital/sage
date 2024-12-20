<?php

namespace App\Admin;

class Blocks
{
    public function __construct()
    {
        add_action('allowed_block_types_all', [$this, 'blacklist'], 100, 2);
    }

    public function blacklist()
    {
        // Reference:
        // https://www.wpexplorer.com/how-to-remove-gutenberg-blocks/
        // https://www.wpexplorer.com/wordpress-core-blocks-list/

        // Existing blocks with Blade templates
        // https://roots.io/acorn/docs/rendering-blade-views/#existing-blocks-with-blade-templates

        $blocks = array_keys( \WP_Block_Type_Registry::get_instance()->get_all_registered() );

        $blacklist = [
            // Design
            'core/button',
            'core/comment-template',
            'core/home-link',
            'core/navigation-link',
            'core/navigation-submenu',
            'core/buttons',
            'core/column',
            'core/columns',
            'core/group',
            'core/more',
            'core/nextpage',
            'core/separator',
            'core/spacer',
            'core/text-columns',

            // Embed
            'core/embed',

            // Media
            'core/cover',
            'core/file',
            'core/gallery',
            'core/image',
            'core/media-text',
            'core/audio',
            'core/video',

            // Reusable
            'core/block',

            // Text
            'core/footnotes',
            'core/heading',
            'core/list',
            'core/code',
            'core/details',
            'core/freeform',
            'core/list-item',
            'core/missing',
            'core/paragraph',
            'core/preformatted',
            'core/pullquote',
            'core/quote',
            'core/table',
            'core/verse',

            // Theme
            'core/avatar',
            'core/comment-author-name',
            'core/comment-content',
            'core/comment-date',
            'core/comment-edit-link',
            'core/comment-reply-link',
            'core/comments',
            'core/comments-pagination',
            'core/comments-pagination-next',
            'core/comments-pagination-numbers',
            'core/comments-pagination-previous',
            'core/comments-title',
            'core/loginout',
            'core/navigation',
            'core/pattern',
            'core/post-author',
            'core/post-author-biography',
            'core/post-author-name',
            'core/post-comments-form',
            'core/post-content',
            'core/post-date',
            'core/post-excerpt',
            'core/post-featured-image',
            'core/post-navigation-link',
            'core/post-template',
            'core/post-terms',
            'core/post-title',
            'core/query',
            'core/query-no-results',
            'core/query-pagination',
            'core/query-pagination-next',
            'core/query-pagination-numbers',
            'core/query-pagination-previous',
            'core/query-title',
            'core/read-more',
            'core/site-logo',
            'core/site-tagline',
            'core/site-title',
            'core/template-part',
            'core/term-description',
            'core/post-comments',

            // Widgets
            'core/legacy-widget',
            'core/widget-group',
            'core/archives',
            'core/calendar',
            'core/categories',
            'core/latest-comments',
            'core/latest-posts',
            'core/page-list',
            'core/page-list-item',
            'core/rss',
            'core/search',
            'core/shortcode',
            'core/social-link',
            'core/tag-cloud',
            'core/html',
            'core/social-links',
        ];

        return array_values( array_diff( $blocks, $blacklist ) );
    }
}
