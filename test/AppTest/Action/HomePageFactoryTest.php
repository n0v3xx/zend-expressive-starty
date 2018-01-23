<?php

namespace AppTest\Action;

use App\Action\AddAction;
use App\Action\AddActionFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageFactoryTest extends TestCase
{
    /** @var ContainerInterface */
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(RouterInterface::class);

        $this->container->get(RouterInterface::class)->willReturn($router);
    }

    public function testFactoryWithoutTemplate()
    {
        $factory = new AddActionFactory();
        $this->container->has(TemplateRendererInterface::class)->willReturn(false);

        $this->assertInstanceOf(AddActionFactory::class, $factory);

        $homePage = $factory($this->container->reveal());

        $this->assertInstanceOf(AddAction::class, $homePage);
    }

    public function testFactoryWithTemplate()
    {
        $factory = new AddActionFactory();
        $this->container->has(TemplateRendererInterface::class)->willReturn(true);
        $this->container
            ->get(TemplateRendererInterface::class)
            ->willReturn($this->prophesize(TemplateRendererInterface::class));

        $this->assertInstanceOf(AddActionFactory::class, $factory);

        $homePage = $factory($this->container->reveal());

        $this->assertInstanceOf(AddAction::class, $homePage);
    }
}
