<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class pokemon_controller extends Controller
{
    public function index()
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=20');

        if ($response->successful()) {
            $dados = $response->json();

            $lista = collect($dados['results'])->map(function ($p) {
                $detalhe = Http::get($p['url'])->json();
                return [
                    'id'   => $detalhe['id'],
                    'nome' => ucfirst($detalhe['name']),
                    'tipo' => ucfirst($detalhe['types'][0]['type']['name']),
                    'foto' => $detalhe['sprites']['front_default'],
                ];
            });

            return view('pokedex', ['pokemons' => $lista]);
        }

        return response()->json(['erro' => 'Falha ao conectar na PokeAPI'], 500);
    }
}