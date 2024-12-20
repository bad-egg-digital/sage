<?php

namespace App\Utilities;

class Colour
{
    public function name2hex($colour = null, $tint = null)
    {
        if(!$colour) return false;

        if($colour == 'black'):
            $hex = '#000000';
        elseif($colour == 'white'):
            $hex = '#FFFFFF';
        else:
            // TODO: replace company_info settings page and lookup function
            $hex = $this->values()[(string)$colour];
        endif;

        if($tint):
            $tints = $this->tints();
            $hex = $this->adjustBrightness($hex, $tints[$tint]);
        endif;

        return $hex;
    }

    public function values()
    {
        $colours = get_field('badegg_colours', 'option');

        $values = [];

        if($colours):
            foreach($colours as $index => $props):
                $index = $index + 1;
                $hex = @$props['hex'];

                if($hex) $values[$this->latinate($index)] = $hex;
            endforeach;
        endif;

        $values['0'] = '#FFFFFF';
        $values['black'] = '#000000';

        return $values;
    }

    public function tints()
    {
      return [
        'lightest'  =>  100,
        'lighter'   =>  66,
        'light'     =>  33,
        '0'         =>   0,
        'dark'      => -33,
        'darker'    => -66,
        'darkest'   => -100,
      ];
    }

    public function is_dark($colour = '#FFFFF', $tint = null, $override = null)
    {

        if($override == 'light') return true;
        if($override == 'dark') return false;

        // https://css-tricks.com/snippets/php/convert-hex-to-rgb/

        if($tint) $colour = $this->adjustBrightness($colour, $this->tints()[$tint]);

        if ( @$colour[0] == '#' ) {
            $colour = substr( $colour, 1 );
        }

        if ( strlen( $colour ) == 6 ) {
            list( $r, $g, $b ) = [
                $colour[0] . $colour[1],
                $colour[2] . $colour[3],
                $colour[4] . $colour[5],
            ];

        } elseif ( strlen( $colour ) == 3 ) {
            list( $r, $g, $b ) = [
                $colour[0] . $colour[0],
                $colour[1] . $colour[1],
                $colour[2] . $colour[2],
            ];

        } else {
            return false;
        }

        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        // return array( 'red' => $r, 'green' => $g, 'blue' => $b );

        $hsp = sqrt(
            0.299 * ($r * $r) +
            0.587 * ($g * $g) +
            0.114 * ($b * $b)
        );

        if($hsp > 200) {
            return false;
        } else {
            return true;
        }
    }

    public function is_light($colour = '#000000', $tint = null)
    {
        if($this->is_dark($colour, $tint)) {
            return false;
        } else {
            return true;
        }
    }

    public function adjustBrightness($hex, $steps)
    {
      // Steps should be between -255 and 255. Negative = darker, positive = lighter
      $steps = max(-255, min(255, $steps));

      // Normalize into a six character long hex string
      $hex = str_replace('#', '', $hex);
      if (strlen($hex) == 3) {
          $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
      }

      // Split into three parts: R, G and B
      $color_parts = str_split($hex, 2);
      $return = '#';

      foreach ($color_parts as $color) {
          $color   = hexdec($color); // Convert to decimal
          $color   = max(0,min(255,$color + $steps)); // Adjust color
          $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
      }

      return $return;
    }

    public function latinate($x = 0)
    {
        $latinate = [
            1 => 'primary',
            2 => 'secondary',
            3 => 'tertiary',
            4 => 'quaternary',
            5 => 'quinary',
            6 => 'senary',
            7 => 'septenary',
            8 => 'octonary',
            9 => 'nonary',
            10 => 'denary',
            11 => 'undenary',
            12 => 'duodenary',
        ];

        if(array_key_exists($x, $latinate)):
            return $latinate[$x];
        else:
            return 0;
        endif;
    }
}
