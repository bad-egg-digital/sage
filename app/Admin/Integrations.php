<?php

namespace App\Admin;

class Integrations
{
    public function __construct()
    {
        add_action( 'wp_head',  [$this, 'FathomAnalytics']);
    }

    public function FathomAnalytics()
    {
        $fathomID = get_field('badegg_integrations_fathom_id', 'option');

        if($fathomID && WP_ENV == 'production'): ?>

<!-- Fathom - beautiful, simple website analytics -->
<script src="https://cdn.usefathom.com/script.js" data-site="<?= $fathomID ?>" defer></script>
<!-- / Fathom -->

        <?php endif;
    }
}
