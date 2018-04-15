<?php

namespace unit\Spark\Module;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Container\ContainerInterface;
use Spark\Module\Plugin;
use Spark\Support\Entity\EntityRegistry;
use Spark\Support\Extension\ExtensionRegistry;

class PluginSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Plugin::class);
    }

    function let(
        ContainerInterface $Container,
        ExtensionRegistry $ExtensionRegistry,
        EntityRegistry $EntityRegistry,
        $functions
    )
    {
        $functions->add_action(
            Argument::type('string'),
            Argument::type('array'),
            Argument::type('int')
        )->shouldBeCalled();
        $functions->reveal();
        $this->beAnInstanceOf(TestPlugin::class);
        $this->beConstructedWith($Container);
        $Container->get(ExtensionRegistry::class)->willReturn($ExtensionRegistry);
        $Container->get(EntityRegistry::class)->willReturn($EntityRegistry);
    }

    function it_registers_extensions(ExtensionRegistry $ExtensionRegistry)
    {
        $ExtensionRegistry->register(['Extension1', 'Extension2'])
                          ->willReturn(['Extension1', 'Extension2']);
        $this->registerExtensions();
    }

    function it_registers_entities(EntityRegistry $EntityRegistry)
    {
        $EntityRegistry->register(['Entity1', 'Entity2'])
            ->willReturn(['Entity1', 'Entity2']);
        $this->registerEntities();
    }
}

class TestPlugin extends \Spark\Module\Plugin
{
    protected $extensions = [
        'Extension1',
        'Extension2'
    ];
    protected $entities = [
        'Entity1',
        'Entity2'
    ];

    public function load()
    {
    }

    public function init()
    {
    }

}