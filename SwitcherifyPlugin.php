<?php
/**
 * Switcherify
 * Twig Extension for easier loop switcher
 *
 * @author    Paper Tiger <info@papertiger.com>
 * @copyright Copyright (c) 2016, Paper Tiger, Inc.
 * @see       http://papertiger.com
 */

namespace Craft;

class SwitcherifyPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t( 'Switcherify' );
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getDeveloper()
    {
        return 'Paper Tiger';
    }

    public function getDeveloperUrl()
    {
        return 'http://papertiger.com';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import( 'plugins.switcherify.twigextensions.SwitcherifyTwigExtension' );

        return new SwitcherifyTwigExtension();
    }

}