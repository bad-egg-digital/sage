<?php

namespace App\Admin;
use ourcodeworld\NameThatColor\ColorInterpreter as NameThatColor;
use App\Utilities;

class Theme
{
    public function __construct()
    {
        add_action( 'after_setup_theme', [$this, 'DynamicPalette'] );
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
