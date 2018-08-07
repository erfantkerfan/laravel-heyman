<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class IgnoreTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl('/welco*')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized657()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl(['welcome_', 'welcome'])->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testUrlIsAuthorized563()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouVisitUrl('welcome_', 'welcome')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouVisitUrl('welcome1')->thisValueShouldAllow(true)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsAuthorized1()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouReachRoute('welcome.name')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testRouteNameIsMatchWithPattern()
    {
        Route::get('/welcome', 'HomeController@index')->name('welcome.name');

        HeyMan::whenYouReachRoute('welcome.*')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouCallAction('\HomeController@index')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testControllerActionIsAuthorized878()
    {
        Route::get('/welcome', 'HomeController@index');

        HeyMan::whenYouCallAction('\HomeController@index')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        Heyman::turnOff()->routeChecks();

        $this->get('welcome')->assertStatus(200);
    }

    public function testFetchingModelsIsAuthorized_Ignorance()
    {
        HeyMan::whenYouFetch('\App\User')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        Heyman::turnOff()->eloquentChecks();

        event('eloquent.retrieved: App\User');
        $this->assertTrue(true);
    }

    public function testEventAuthorized_Ignorance()
    {
        HeyMan::whenEventHappens('hey')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        Heyman::turnOff()->eventChecks();

        event('hey');
        $this->assertTrue(true);
    }

    public function testFetchingModelsIsAuthorized_closure_Ignorance()
    {
        HeyMan::whenYouFetch('\App\User')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();
        HeyMan::whenYouCreate('\App\User2')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        config()->set('heyman_ignore_eloquent', '2222');

        Heyman::turnOff()->eloquentChecks(function () {
            event('eloquent.retrieved: App\User');
        });

        $this->assertEquals(config('heyman_ignore_eloquent'), '2222');
    }

    public function testViewIsAuthorized21134()
    {
        HeyMan::whenYouMakeView(['welcome', 'errors.503'])
            ->thisValueShouldAllow(false)
            ->otherwise()
            ->weDenyAccess();

        Heyman::turnOff()->viewChecks();

        view('welcome');
        $this->assertTrue(true);
    }

    public function testViewIsAuthorized2134()
    {
        HeyMan::whenYouMakeView(['welcome', 'errors.503'])
            ->thisValueShouldAllow(false)
            ->otherwise()
            ->weDenyAccess();

        Heyman::turnOff()->allChecks();

        view('welcome');
        $this->assertTrue(true);
    }

    public function test_check_would_be_turned_On_again()
    {
        Route::put('put', function () {
        });
        HeyMan::whenYouSendPut('put')->thisValueShouldAllow(false)->otherwise()->weDenyAccess();

        Heyman::turnOff()->allChecks();
        Heyman::turnOn()->allChecks();

        $this->put('put')->assertStatus(403);
    }
}
