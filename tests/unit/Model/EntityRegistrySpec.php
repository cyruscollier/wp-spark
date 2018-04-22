<?php

namespace unit\Spark\Model;

use Spark\Model\EntityRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spark\Model\PostType\Post;
use Spark\Model\Taxonomy\Category;
use Spark\Model\Values\PostDate;

class EntityRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EntityRegistry::class);
    }

    function it_registers_one_or_more_entity_classes()
    {
        $entity_classes = [Post::class, Category::class];
        $this->register($entity_classes)
             ->shouldReturn($entity_classes);
    }

    function it_skips_an_entity_class_already_registered()
    {
        $this->register([Post::class]);
        $this->register([Post::class, Category::class])
            ->shouldReturn([Category::class]);
    }

    function it_fails_to_register_a_non_entity_type()
    {
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringRegister(['not_an_entity_class']);
    }

    function it_deregisters_one_or_more_entity_classes()
    {
        $entity_classes = [Post::class, Category::class];
        $this->register($entity_classes);
        $this->deregister($entity_classes)
             ->shouldReturn($entity_classes);
    }

    function it_skips_an_entity_class_not_registered()
    {
        $this->register([Post::class]);
        $this->deregister([Post::class, Category::class])
            ->shouldReturn([Post::class]);
    }

    function it_fails_to_deregister_a_non_entity_type()
    {
        $this->shouldThrow(\InvalidArgumentException::class)
             ->duringDeregister(['not_an_entity_class']);
    }

    function it_gets_a_registered_entity_class_by_registry_key()
    {
        $this->register([Post::class]);
        $this->get('post')->shouldReturn(Post::class);
        $this->get('not_a_valid_key')->shouldReturn(false);
    }
}
