<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use MarcReichel\IGDBLaravel\Models\Game;
use Livewire\Component;
use Illuminate\Support\Str;

class PopularGames extends Component
{
    public $popularGames = [];

    public function loadPopularGames()
    {

        $popularGamesUnformatted = $this->popularGames =  Game::select([
            'name' ,
            'first_release_date',
            'platforms',
            'rating',
            'slug',
            'rating_count'

        ])
        ->with(['cover' => '*','platforms' => 'abbreviation'])
        ->where([
            ['platforms' , [48,49,130,6]],
            
        ])
        ->limit(12)
        ->orderBy('rating_count', 'asc')
        ->get();

        $this->popularGames = $this->formatForView($popularGamesUnformatted);

        collect($this->popularGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('gameWithRatingAdded', [
                'slug' => $game['slug'],
                'rating' => $game['rating'] / 100,
            ]);
        });

       
    }

    public function render()
    {
        return view('livewire.popular-games');
    }

    private function formatForView($games) 
    {
        return collect($games)->map( function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => isset($game['rating']) ? round($game['rating']) : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            ]);
        })->toArray();
    }


}
