<?php

namespace App\Admin;

class Integrations
{
    public function __construct()
    {
        add_action( 'wp_head',  [$this, 'FathomAnalytics']);
        add_action( 'wp_footer',  [$this, 'FontAwesomeKit'], 100);
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

    public function FontAwesomeKit()
    {
        $kit = get_field('badegg_integrations_fontawesome_kit', 'option');

        if($kit): ?>

<!-- FontAwesome Kit -->
<script src="https://kit.fontawesome.com/<?= $kit ?>.js" crossorigin="anonymous"></script>
<!-- / FontAwesome Kit -->

        <?php endif;
    }
}
