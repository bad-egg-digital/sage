<?php

namespace App\ACF;

class CloneGroup
{
    public function __construct()
    {

    }
    public function block_background()
    {
        return [
            'contrast',
            'bg_colour',
            'bg_tint',
        ];
    }

    public function block_intro()
    {
        return [
            'overline',
            'heading',
            'blurb',
            'intro_alignment',
        ];
    }

    public function block_footer()
    {
        return [
            'blurb_footer',
            'links',
            'footer_alignment',
        ];
    }

    public function block_settings()
    {
        return [
            'section_anchor_id',
            'padding_top',
            'padding_bottom',
            'container_width',
            'angle_status',
            'angle_position',
            'angle_direction',
            'angle_colour',
            'angle_tint',
        ];
    }

    public function block_all()
    {
        return array_merge($this->block_intro(), $this->block_footer(), $this->block_settings(), $this->block_background());
    }
}
