<?php

namespace unit\Spark\Extension\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Extension\Entity\Entity;

class EntitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Spark\Extension\Entity\Entity');
    }
        
    function let()
    {
        $this->beAnInstanceOf(EntityTest::class);
    }    
    
    function it_registers_the_init_action( $functions ) {
        $functions->add_action('init', Argument::type('callable'), 1)->willReturn(true);
        $this->register()->shouldReturn(true);
    }
    
    function it_merges_and_formats_labels()
    {
        $this->getLabels()->shouldHaveKeyWithValue('name', 'Tests');
        $this->getLabels()->shouldHaveKeyWithValue('singular_name', 'Test');
        $this->getLabels()->shouldHaveKeyWithValue('not_found', 'No tests found');
        $this->getLabels()->shouldHaveKeyWithValue('test_default', 'foobar');
        $this->getLabels()->shouldHaveKeyWithValue('menu_name', 'Test');
    }
    
    function it_merges_and_formats_rewrite()
    {
        $this->getRewrite()->shouldHaveKeyWithValue('test_default', 'foobar');
        $this->getRewrite()->shouldHaveKeyWithValue('test_override', 'barbaz');
        $this->getRewrite()->shouldHaveKeyWithValue('slug', 'test-post');
    }
    
    function it_generates_configuration_data()
    {
        $this->getConfig()->shouldHaveKey('labels');
        $this->getConfig()->shouldHaveKey('rewrite');
        $this->getConfig()->shouldHaveKeyWithValue('test_config1', 'foo');
        $this->getConfig()->shouldHaveKeyWithValue('test_config2', 'bar');
    }
}

class EntityTest extends Entity
{
    const NAME = 'test';
    
    protected $slug = 'test-post';
    protected $label_singular = 'Test';
    protected $label_plural = 'Tests';

    protected $labels = ['menu_name' => '@S'];
    protected $labels_defaults = ['test_default' => 'foobar'];
    
    protected $rewrite = ['test_override' => 'barbaz'];
    protected $rewrite_defaults = ['test_default' => 'foobar'];
    
    protected $config = ['test_config2' => 'bar'];
    protected $config_defaults = ['test_config1' => 'foo'];
    
    function getType() { return 'EntityTest'; }
        
    function isRegistered() { return true; }
    
    function deregister() { return true; }
    
    protected function registerEntity( $config )
    {
        return $config;
    }
}
