<?php

use App\Providers\HorizonServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\ServiceProvider;

uses(RefreshDatabase::class);

describe('Provider HorizonServiceProvider', function () {

    it('registra a gate "viewHorizon"', function () {
        $provider = new HorizonServiceProvider(app());
        $provider->register(); // se necessário
        $provider->boot();

        $provider->callBootingCallbacks(); // garante que boot() seja chamado

        expect(Gate::has('viewHorizon'))->toBeTrue();
    });

    it('gate "viewHorizon" nega acesso por padrão', function () {
        $usuario = new class {
            public $email = 'nao-autorizado@example.com';
        };

        $resultado = Gate::check('viewHorizon', [$usuario]);

        expect($resultado)->toBeFalse();
    });

});
