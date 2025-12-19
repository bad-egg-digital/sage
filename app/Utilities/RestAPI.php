<?php

namespace App\Utilities;

class RestAPI
{
    public function __construct()
    {
        add_action( 'rest_api_init', [$this, 'blocks']);
    }

    public function blocks( )
    {
        $restBase = 'badegg/v1';

        register_rest_route($restBase, '/blocks/container-widths', [
            'methods' => 'GET',
            'callback' => [ $this, 'containerWidths'],
            'permission_callback' => function(){
                return true;
            },
        ]);
    }

    public function containerWidths()
    {
        $containerWidths = [
            [ 'label' => __('Auto', 'badegg'),          'value' => 0        ],
            [ 'label' => __('Narrow', 'badegg'),        'value' => 'narrow' ],
            [ 'label' => __('Small', 'badegg'),         'value' => 'small'  ],
            [ 'label' => __('Medium', 'badegg'),        'value' => 'medium' ],
            [ 'label' => __('Large', 'badegg'),         'value' => 'large'  ],
            [ 'label' => __('Edge to edge', 'badegg'),  'value' => 'full'   ],
        ];

        return rest_ensure_response($containerWidths);
    }
}
