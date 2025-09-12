<?php

use App\Providers\TelescopeServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;

uses(RefreshDatabase::class);

describe('Provider TelescopeServiceProvider', function () {

    it('registra a gate "viewTelescope"', function () {
        $provider = new TelescopeServiceProvider(app());
        $provider->boot();

        expect(Gate::has('viewTelescope'))->toBeTrue();
    });

    it('gate "viewTelescope" nega acesso por padrão', function () {
        $usuario = new class {
            public $email = 'nao-autorizado@example.com';
        };

        $resultado = Gate::check('viewTelescope', [$usuario]);

        expect($resultado)->toBeFalse();
    });

    it('oculta detalhes sensíveis da requisição em ambiente não local', function () {
        config()->set('app.env', 'production');

        $provider = new TelescopeServiceProvider(app());
        $provider->register();

        expect(Telescope::$hiddenRequestParameters)->toContain('_token');
        expect(Telescope::$hiddenRequestHeaders)->toContain('cookie');
        expect(Telescope::$hiddenRequestHeaders)->toContain('x-csrf-token');
        expect(Telescope::$hiddenRequestHeaders)->toContain('x-xsrf-token');
    });

    it('executa o método register sem falhas', function () {
        config(['app.env' => 'production']);

        $provider = new TelescopeServiceProvider(app());

        expect(fn() => $provider->register())->not->toThrow(Exception::class);
    });

    it('registra o filtro do Telescope sem falhas', function () {
        config(['app.env' => 'production']);

        $provider = new TelescopeServiceProvider(app());

        expect(fn() => $provider->register())->not->toThrow(Exception::class);
    });

    it('não oculta detalhes sensíveis em ambiente local', function () {
        
        Telescope::$hiddenRequestParameters = [];
        Telescope::$hiddenRequestHeaders = [];

        // Cria mock da aplicação simulando ambiente local
        $app = Mockery::mock(\Illuminate\Contracts\Foundation\Application::class);
        $app->shouldReceive('environment')->andReturn('local');

        $provider = new TelescopeServiceProvider($app);

        $reflection = new ReflectionClass($provider);
        $method = $reflection->getMethod('hideSensitiveRequestDetails');
        $method->setAccessible(true);
        $method->invoke($provider);

        expect(Telescope::$hiddenRequestParameters)->toBe([]);
        expect(Telescope::$hiddenRequestHeaders)->toBe([]);
    });
});
