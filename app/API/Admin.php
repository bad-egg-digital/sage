<?php

namespace App\API;

class Admin
{
    public function __construct()
    {
        add_action( 'rest_api_init', [$this, 'blocks']);
    }

    public function blocks( )
    {
        register_rest_route('badegg/v1', '/blocks/container_width', [
            'methods' => 'GET',
            'callback' => [ $this, 'container_width'],
            'permission_callback' => function(){
                return true;
            },
        ]);
    }

    public function container_width()
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
