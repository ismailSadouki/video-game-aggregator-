<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Game;

use Livewire\Component;

class ComingSoon extends Component
{

    public $comingSoon = [];
    public function loadComingSoon() 
    {
        $current = Carbon::now()->timestamp;  
        $comingSoonUnformatted = $this->comingSoon =  Game::select([
            'name' ,
            'first_release_date',
            'platforms',
            'rating',
            'slug'

        ])
        ->with(['cover' => '*','platforms' => 'abbreviation'])
        ->where([
            ['platforms' , [48,49,130,6]],
            ['first_release_date', '>=', $current],
        ])
        ->limit(4)
        ->orderBy('popularity', 'desc')
        ->get();


        $this->comingSoon = $this->formatForView($comingSoonUnformatted);

    }

    public function render()
    {
        return view('livewire.coming-soon');
    }

    private function formatForView($games) 
    {
        return collect($games)->map( function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']),
                'releaseDate' => Carbon::parse($game->first_release_date)->format('M d, Y'),
            ]);
        })->toArray();
    }
}
