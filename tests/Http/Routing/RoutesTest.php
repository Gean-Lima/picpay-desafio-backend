<?php

use Neo\PicpayDesafioBackend\Http\Routing\Route;
use Neo\PicpayDesafioBackend\Http\Routing\RouteDuplicatedException;
use Neo\PicpayDesafioBackend\Http\Routing\RouteMethod;
use Neo\PicpayDesafioBackend\Http\Routing\Routes;
use Neo\PicpayDesafioBackend\Test\TestCase;

class RoutesTest extends TestCase
{
    protected function setUp(): void
    {
        Routes::reset();
    }

    public function testMustAddANewRouteToTheList()
    {
        $routes = Routes::getInstance();

        $routes->addRoute(new Route(RouteMethod::GET, '/api/test', function() {}));

        $list = $routes->getList();

        $this->assertEquals(1, count($list));
        $this->assertArrayHasKey('GET___api_test', $list);
    }

    public function testThereMustBeADuplicateRouteException()
    {
        $this->expectException(RouteDuplicatedException::class);

        $routes = Routes::getInstance();

        $routes->addRoute(new Route(RouteMethod::GET, '/api/test', function() {}));
        $routes->addRoute(new Route(RouteMethod::GET, '/api/test', function() {}));
    }

    public function testAddAGetRouteWithTheStaticMethod()
    {
        $routes = Routes::getInstance();

        Route::get('/api/test', function() {});

        $list = $routes->getList();

        $this->assertEquals(1, count($list));
        $this->assertArrayHasKey('GET___api_test', $list);
    }
}
