<?php

namespace Liip\UrlAutoConverterBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Liip\UrlAutoConverterBundle\DependencyInjection\LiipUrlAutoConverterExtension;

class LiipUrlAutoConverterExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $configuration;

    public function testLoadDefaults()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new LiipUrlAutoConverterExtension();
        $loader->load(array(), $this->configuration);

        $this->assertParameter('', 'liip_url_auto_converter.linkclass');
        $this->assertParameter('_blank', 'liip_url_auto_converter.target');
        $this->assertParameter(false, 'liip_url_auto_converter.debugmode');
        $this->assertHasDefinition('liip_url_auto_converter.twig.extension');
    }

    public function testTargetCustom()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new LiipUrlAutoConverterExtension();
        $loader->load(array(array('linkclass' => 'foo', 'target' => 'bar', 'debugmode' => true)), $this->configuration);

        $this->assertParameter('foo', 'liip_url_auto_converter.linkclass');
        $this->assertParameter('bar', 'liip_url_auto_converter.target');
        $this->assertParameter(true, 'liip_url_auto_converter.debugmode');
        $this->assertHasDefinition('liip_url_auto_converter.twig.extension');
    }

    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is incorrect', $key));
    }

    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is incorrect', $key));
    }

    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
