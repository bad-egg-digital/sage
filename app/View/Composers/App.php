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
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'Colour' => new Utilities\Colour,
            'VideoSrcset' => new Utilities\VideoSrcset,
            'ImageSrcset' => new Utilities\ImageSrcset,
            'siteName' => $this->siteName(),
            'siteLogo' => @file_get_contents(get_template_directory() . '/resources/images/logo-rhythm-road-entertainment.svg'),
            'company_legal' => get_field('badegg_company_legal', 'option'),
            'company_tel' => get_field('badegg_company_tel', 'option'),
            'company_email' => get_field('badegg_company_email', 'option'),
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }
}
