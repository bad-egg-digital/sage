<?php

namespace App\Utilities;

class CssClasses {
    public function section($props = [], $name = 'unnamed', $knockout = false)
    {
        $defaults = [
            'padding_top' => null,
            'padding_bottom' => null,
            'bg_colour' => null,
            'bg_tint' => null,
            'contrast' => null,
            'bg_image' => null,
        ];

        $props = wp_parse_args($props, $defaults);

        $Colour = new Colour;
        $hex = $Colour->name2hex($props['bg_colour'], $props['bg_tint']);

        $classes = [
            'section',
            'section-' . str_replace('/', '-', $name),
        ];

        if($props['bg_colour'])
            $classes[] = 'bg-' . $this->colourTint([
                'colour' => $props['bg_colour'],
                'tint' => $props['bg_tint'],
            ]);

        if(($props['contrast'] && $knockout))
            $classes[] = 'knockout';

        if(!$props['padding_top'])
            $classes[] = 'section-zero-top';

        if(!$props['padding_bottom'])
            $classes[] = 'section-zero-bottom';

        if($props['bg_image'])
            $classes[] = "has-bg-image";

        return $classes;
    }

    public function container($args = [], $bg_props = [])
    {
        $args = wp_parse_args($args, [
            'width' => null,
            'location' => null,
            'section' => false,
            'align' => null,
            'wysiwyg' => false,
        ]);

        $bg_props = wp_parse_args($bg_props, [
            'bg_colour' => null,
            'bg_tint' => null,
            'contrast' => null,
        ]);

        $Colour = new Utilities\Colour;
        $hex = $Colour->name2hex($bg_props['bg_colour'], $bg_props['bg_tint']);

        $classes = [
            'container',
        ];

        if($args['width'])
            $classes[] = 'container-' . $args['width'];

        if($args['location'])
            $classes[] = $args['location'];

        if($args['section'])
            $classes[] = 'section';

        if(str_contains($args['location'], 'intro'))
            $classes[] = 'section-zero-top';

        if(str_contains($args['location'], 'footer'))
            $classes[] = 'section-zero-bottom';

        if($args['wysiwyg'])
            $classes[] = 'wysiwyg';

        if($args['align'])
            $classes[] = 'align-' . $args['align'];

        if(($bg_props['contrast']))
            $classes[] = 'knockout';

        return $classes;
    }

    public function button($args = [])
    {
        $default_args = [
            'colour' => null,
            'style' => null,
        ];

        $args = wp_parse_args($args, $default_args);

        $classes = [
            'button',
        ];

        if($args['colour']) $classes[] = $args['colour'];
        if($args['style']) $classes[] = $args['style'];

        return $classes;
    }

    public function colourTint($props = [])
    {
        if(@$props['colour']):
            $colour = $props['colour'];

            if($props['colour'] != 'black' && @$props['tint']):
                $colour .= '-' . $props['tint'];
            endif;
        else:
            $colour = 'white';
        endif;

        return $colour;
    }

    public function is_knockout_block($name = null)
    {
        $blacklist = [
            'badegg/acfdemo',
        ];

        if(in_array($name, $blacklist)):
            return false;
        else:
            return true;
        endif;
    }
}
