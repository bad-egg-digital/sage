<?php

namespace App\ACF;

class CloneGroup
{
    public function __construct()
    {

    }
    public function background()
    {
        return [
            'contrast',
            'bg_type',
            'bg_colour',
            'bg_tint',
            'bg_opacity',
            'bg_image',
            'bg_video',
            'pattern',
            'pattern_top',
            'pattern_bottom',
            'padding_top',
            'padding_bottom',
        ];
    }
}
