<?php

namespace Blocks\Content;
use App\Utilities;
use App\ACF;

class Content
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'init']);
    }

    public function init()
    {
        acf_register_block_type([
            'name'              => 'badegg/content',
            'title'             => __('Content'),
            'description'       => __('Wordpress blocks inside a wrapper'),
            'render_callback'   => [ $this, 'render'],
            'category'          => 'badegg',
            'icon'              => 'columns',
            'supports'          => [
                'align' => false,
                'jsx' => true,
            ],
            'example' => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                      'inserter' => true,
                    ],
                ],
            ],
        ]);
    }

    public function render($block, $content = '', $is_preview = false)
    {
          $name = basename(__FILE__, '.php');
          $themeURL = get_template_directory_uri();

          if($is_preview && @$block['data']['inserter']):
              echo '<img style="display: block; width: 100%" src="' . $themeURL . '/resources/views/blocks/' . $name . '/' . $name . '.jpg" />';
              return;
          endif;

          $CssClasses = new Utilities\CssClasses;
          $Colour     = new Utilities\Colour;
          $CloneGroup = new ACF\CloneGroup;

          $data = [];

          $fields = [

          ];

          $fields = array_merge($fields, $CloneGroup->block_all());

          foreach($fields as $field):
              $data[$field] = get_field($field);
          endforeach;

          unset($block['data']);
          $block['name'] = str_replace('acf/', '', $block['name']);

          $data = array_merge($data, $block);
          $data['section_classes'] = $CssClasses->section($data);
          $data['allowed_blocks'] = $this->inner_blocks();
          $data['block'] = $block;

          echo \Roots\view("blocks.$name.$name", [
              'data' => $data,
              'block' => $block,
          ])->render();
      }

      public function inner_blocks()
      {
        return [
              // Design
              'core/separator',
              'core/spacer',

              // Media
              'core/cover',
              'core/file',
              'core/gallery',
              'core/image',
              'core/media-text',
              'core/audio',
              'core/video',

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
        ];
      }
}
