<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use App\Utilities;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Retrieve the site name.
     */
    public function siteName(): string
    {
        return get_bloginfo('name', 'display');
    }

    public function with()
    {
        return [
            'Colour' => new Utilities\Colour,
            'VideoSrcset' => new Utilities\VideoSrcset,
            'ImageSrcset' => new Utilities\ImageSrcset,
            'siteName' => $this->siteName(),
            'company_legal' => get_field('badegg_company_legal', 'option'),
            'company_tel' => get_field('badegg_company_tel', 'option'),
            'company_email' => get_field('badegg_company_email', 'option'),
        ];
    }
}
