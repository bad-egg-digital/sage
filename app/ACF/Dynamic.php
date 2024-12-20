<?php

namespace App\ACF;
use ourcodeworld\NameThatColor\ColorInterpreter as NameThatColor;
use App\Utilities;

class Dynamic
{
    public function __construct()
    {
        add_filter('acf/load_field/name=colour',                [ $this, 'load_colours'   ]);
        add_filter('acf/load_field/name=bg_colour',             [ $this, 'load_colours'   ]);
        add_filter('acf/load_field/name=tint',                  [ $this, 'load_tints'   ]);
        add_filter('acf/load_field/name=bg_tint',               [ $this, 'load_tints'   ]);
        add_filter('acf/load_field/name=fontawesome_regular',   [ $this, 'load_fontawesome_regular_icons' ]);
        add_filter('acf/load_field/name=fontawesome_solid',     [ $this, 'load_fontawesome_solid_icons'   ]);
        add_filter('acf/load_field/name=fontawesome_brands',    [ $this, 'load_fontawesome_brand_icons'   ]);
    }

    public function load_colours( $field )
    {
        $colour = new Utilities\Colour;
        $NameThatColour = new NameThatColor;

        $colours = $colour->values();

        $field['choices'] = [];

        foreach($colours as $slug => $hex):
            $field['choices'][$slug] = '<i class="fas fa-circle" style="color: '. $hex .'"></i> ' . @$NameThatColour->name($hex)['name'];
        endforeach;

        return $field;

    }

    public function load_tints( $field )
    {
        $colour = new Utilities\Colour;
        $tints = $colour->tints();

        $field['choices'] = [];

        foreach($tints as $slug => $hex):
            if($slug):
                $field['choices'][$slug] = ucfirst($slug);

            else:
                $field['choices'][0] = 'None';
            endif;
        endforeach;

        return $field;
    }

    public function load_fontawesome_regular_icons( $field )
    {
        $field['choices'] = [];
        $field['choices'] = $this->fontawesome_choices('regular');

        return $field;
    }

    public function load_fontawesome_solid_icons( $field )
    {
        $field['choices'] = [];
        $field['choices'] = $this->fontawesome_choices('solid');

        return $field;
    }

    public function load_fontawesome_brand_icons( $field )
    {
        $field['choices'] = [];
        $field['choices'] = $this->fontawesome_choices('brands');

        return $field;
    }

    public function fontawesome_choices($set = 'solid')
    {
        $path = get_stylesheet_directory() . '/resources/json/font-awesome-' . $set . '.json';

        $json = @file_get_contents($path);

        if(!$json) return false;
        $icons = json_decode($json, true);

        $choices = [
            '0' => '<i class="fa-solid"></i> <span>Please select an icon</span>',
        ];

        foreach($icons as $slug => $props):
            if(in_array($slug, range(0,9))) continue;

            $choices[$slug] = '<i class="fa-'.$set.' fa-'.$slug.'" style="color: #2271b1;"></i> <span>' . (ucwords(str_replace('-', ' ', $slug))) . '</span>';
        endforeach;

        return $choices;
    }
}

