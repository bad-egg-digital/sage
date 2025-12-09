<?php

namespace Blocks\Editor;
use App\Utilities;
use App\ACF;

class Editor
{
  public function __construct()
  {
    add_action('acf/init', [$this, 'init']);
  }

  public function init()
  {
      acf_register_block_type([
          'name'              => 'badegg-editor',
          'title'             => __('Text Editor'),
          'description'       => __('Long form text content with support for things like headings, lists, and images.'),
          'render_callback'   => [ $this, 'render'],
          'category'          => 'badegg',
          'icon'              => 'media-document',
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

  public function render($block, string $content = '', bool $is_preview = false, int $post_id = 0)
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
    $data['allowed_blocks'] = \App\block_whitelist();
    $data['template'] = $this->default_template();
    $data['block'] = $block;

    echo \Roots\view("blocks.$name.$name", [
      'data' => $data,
      'block' => $block,
    ])->render();
  }

  public function default_template()
  {
    return [
      [
        'core/heading',
        [
          'level' => 1,
          'placeholder' => 'Heading',
        ],
      ],
      [
        'core/paragraph',
        [
          'placeholder' => 'You can type your own text, change the heading level, or delete it altogether. You can also type over this text.',
        ],
      ],
      [
        'core/paragraph',
        [
          'placeholder' => 'To adjust block settings, click the Text Editor icon floating above this block to display them in the sidebar.',
        ],
      ],
    ];
  }
}
