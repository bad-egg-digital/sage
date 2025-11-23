<?php

namespace App\Utilities;

class CssClasses {
    public function section($props = [])
    {
        $Colour = new Colour;
        $hex = $Colour->name2hex(@$props['bg_colour'], @$props['bg_tint']);

        $pattern = @$props['pattern'];
        $pattern_top = @$props['pattern_top'];
        $pattern_bottom = @$props['pattern_bottom'];

        $classes = [
            'section',
            'section-' . $props['name'],
            // 'section-' . str_replace('acf/', '', $props['name']),
            'bg-' . $this->colourTint([
                'colour' => @$props['bg_colour'],
                'tint' => @$props['bg_tint'],
            ]),
        ];

        if($Colour->is_dark($hex) && $this->is_knockout_block($props['name']))
            $classes[] = 'knockout';

        if(@$props['padding_top'])
            $classes[] = 'section-zero-top';

        if(@$props['padding_bottom'])
            $classes[] = 'section-zero-bottom';

        if($pattern):
            if($pattern == 'both'):
                $classes[] =  'pattern-top';
                $classes[] =  'pattern-bottom';

            else:
                $classes[] = 'pattern-' . $pattern;

            endif;

            if(in_array($pattern, ['top', 'both']))
                $classes[] = 'pattern-top-' . $this->colourTint($pattern_top);

            if(in_array($pattern, ['bottom', 'both']))
                $classes[] = 'pattern-bottom-' . $this->colourTint($pattern_bottom);

        endif;

        if(@$props['bg_image'])
            $classes[] = "bg-watermarked";

        if(@$props['className']) $args = array_merge($classes, explode(' ', $props['className']));

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
            'bad-example',
        ];

        if(in_array($name, $blacklist)):
            return false;
        else:
            return true;
        endif;
    }
}
