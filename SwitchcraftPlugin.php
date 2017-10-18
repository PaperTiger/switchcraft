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
    protected $name = 'Switchcraft';
    protected $version = '1.0.0';
    protected $developer = 'Paper Tiger';
    protected $developerUrl = 'http://papertiger.com';
    protected $pluginUrl = 'https://github.com/papertiger/Switchcraft';
    protected $docUrl = $this->getPluginUrl() . '/blob/master/README.md';
    protected $relUrl = 'https://raw.githubusercontent.com/papertiger/Switchcraft/master/changelog.json';

    public function getName()
    {
        return $this->name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getDeveloper()
    {
        return $this->developer;
    }

    public function getDeveloperUrl()
    {
        return $this->developerUrl;
    }

    public function getPluginUrl()
    {
        return $this->pluginUrl;
    }

    public function getDocumentationUrl()
    {
        return $this->docUrl;
    }

    public function getReleaseFeedUrl()
    {
        return $this->relUrl;
    }

    public function addTwigExtension()
    {
        Craft::import( 'plugins.switchcraft.twigextensions.SwitchcraftTwigExtension' );

        return new SwitchcraftTwigExtension();
    }

}
