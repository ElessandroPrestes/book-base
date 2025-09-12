<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

describe('Model User', function () {

    it('possui os campos preenchíveis "name", "email" e "password"', function () {
        $usuario = new User([
            'name' => 'Elessandro',
            'email' => 'elessandro@example.com',
            'password' => 'senha123',
        ]);

        expect($usuario->name)->toBe('Elessandro');
        expect($usuario->email)->toBe('elessandro@example.com');
        expect(Hash::check('senha123', $usuario->password))->toBeTrue();
    });

    it('oculta os campos "password" e "remember_token" na serialização', function () {
        $usuario = User::factory()->make([
            'password' => 'senha123',
            'remember_token' => 'token123',
        ]);

        $dados = $usuario->toArray();

        expect($dados)->not->toHaveKey('password');
        expect($dados)->not->toHaveKey('remember_token');
    });

    it('realiza o cast correto para "email_verified_at" e "password"', function () {
        $usuario = User::factory()->make([
            'email_verified_at' => now(),
            'password' => 'senha123',
        ]);

        expect($usuario->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class);
        expect(\Illuminate\Support\Facades\Hash::check('senha123', $usuario->password))->toBeTrue();

    });

});
