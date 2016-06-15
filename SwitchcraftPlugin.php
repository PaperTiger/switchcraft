<?php
/**
 * Switchcraft
 * A Craft CMS Twig Extension for easier and human readable loop switcher
 *
 * @author    Paper Tiger <info@papertiger.com>
 * @copyright Copyright (c) 2016, Paper Tiger, Inc.
 * @see       http://papertiger.com
 */

namespace Craft;

class SwitchcraftPlugin extends BasePlugin
{
    public function getName()
    {
        return Craft::t( 'Switchcraft' );
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'Paper Tiger';
    }

    public function getDeveloperUrl()
    {
        return 'http://papertiger.com';
    }
    
    public function getPluginUrl()
    {
        return 'https://github.com/papertiger/Switchcraft';
    }

    public function getDocumentationUrl()
    {
        return $this->getPluginUrl() . '/blob/master/README.md';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/papertiger/Switchcraft/master/changelog.json';
    }
    
    public function getSourceLanguage()
    {
        return 'en';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import( 'plugins.switchcraft.twigextensions.SwitchcraftTwigExtension' );

        return new SwitchcraftTwigExtension();
    }

}