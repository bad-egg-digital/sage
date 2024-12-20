<?php

namespace App\Blocks;
use App\Utilities;
use App\ACF;

class BadExample
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'init']);
    }

    public function init()
    {
        acf_register_block_type([
            'name'              => 'badegg/bad-example',
            'title'             => __('Bad Example'),
            'description'       => __('This is an example block'),
            'render_callback'   => [ $this, 'render'],
            'category'          => 'layout',
            'multiple'          => false,
            'icon'              => [
                'src'   => 'dismiss',
            ],
            'supports'          => [
                'align' => false,
            ],
        ]);
    }

    public function render($block)
    {
        $CssClasses = new Utilities\CssClasses;
        $Colour     = new Utilities\Colour;
        $CloneGroup = new ACF\CloneGroup;

        $data = [];

        $fields = [
            'heading',
            'blurb',
        ];

        $fields = array_merge($fields, $CloneGroup->background());

        foreach($fields as $field):
            $data[$field] = get_field($field);
        endforeach;

        unset($block['data']);
        $block['name'] = str_replace('acf/', '', $block['name']);

        $data = array_merge($data, $block);
        $data['section_classes'] = $CssClasses->section($data);
        $data['block'] = $block;

        $data['knockout'] = ($Colour->is_dark($data['bg_colour'], $data['bg_tint'], $data['contrast'])) ? null : 'knockout';

        echo \Roots\view('blocks.bad-example', [
            'data' => $data,
            'block' => $block,
        ])->render();
    }
}
