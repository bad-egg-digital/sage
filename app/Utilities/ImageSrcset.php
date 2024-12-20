<?php

namespace App\Utilities;

class ImageSrcset
{
    public function add($args = [])
    {
        $args = wp_parse_args($args, $this->default_args());
        $multipliers = $this->multipliers();

        if(is_null($args['height'])) $args['height'] = $args['width'];


        if($args['sizes'] < 5) $multipliers = array_slice($multipliers, 0, $args['sizes']);

        foreach ( $multipliers as $slug => $scale ):
            add_image_size (
                $args['name'] . '-' . $slug,
                round((int)$args['width'] * $scale),
                round((int)$args['height'] * $scale),
                $args['crop']
            );
        endforeach;
    }

    public function default_args()
    {
        return [
            'name' => 'hero',
            'width' => 1920,
            'height' => null,
            'crop' => true,
            'sizes' => 5,
        ];
    }

    public function multipliers()
    {
        return [
            'xl' => 1,
            'lg' => 0.75,
            'md' => 0.52083333,
            'sm' => 0.33333333,
            'xs' => 0.20833333,
        ];
    }

    public function render($args = [])
    {
        global $_wp_additional_image_sizes;

        $default_args = [
            'name' => 'hero',
            'image' => null,
            'lazy' => true,
            'sizes' => 5,
            'class' => null,
        ];

        $args = wp_parse_args($args, $default_args);
        $name = $args['name'];
        $image = ($args['image']) ? $args['image'] : get_post_thumbnail_id();

        if(!$image) return false;

        $properties = @$_wp_additional_image_sizes[$name . '-xl'];
        $width = @$properties['width'];
        $height = @$properties['height'];

        $sizes = [
          'xl' => 1,
          'lg' => 0.75,
          'md' => 0.52083333,
          'sm' => 0.33333333,
          'xs' => 0.20833333,
        ];

        if($args['sizes'] < 5) $sizes = array_slice($sizes, 0, $args['sizes']);

        $class = $name . '-image';
        if($args['class']) $class .= ' ' . $args['class'];

        ob_start();

        $full = wp_get_attachment_image_src($image, $name . '-xl');
        $lazy = wp_get_attachment_image_src($image, 'lazy');
        $alt = get_post_meta( $image, '_wp_attachment_image_alt', true );

        $srcsets = [];
        foreach($sizes as $size => $multiplier) {
            $file = wp_get_attachment_image_src($image, $name . '-' . $size);
            $srcsets[] = $file[0] . ' ' . $file[1] . 'w';
        }

        $atts = [
        'class' => $class,
        'src' => $full[0],
        'srcset' => implode(', ', $srcsets),
        'width' => $width,
        'height' => $height,
        'alt' => $alt,
        ];

        if($args['lazy']):
            $atts['class'] .= ' lazy';
            $atts['src'] = $lazy[0];
            $atts['srcset'] = null;
            $atts['data-src'] = $full[0];
            $atts['data-srcset'] = implode(', ', $srcsets);
        endif;

    ?>

        <img
            <?php foreach($atts as $att => $value):
                if($value) echo $att . '="' . $value . '" ';
            endforeach; ?>
        />

    <?php
        return ob_get_clean();
    }
}
