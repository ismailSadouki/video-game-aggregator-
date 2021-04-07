<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Game;


class MostAnticipated extends Component
{

    public $mostAnticipated = [];

    public function loadMostAnticipated()
    {
        $current = Carbon::now()->timestamp;
        $afterFourMonths  = Carbon::now()->addMonths(4)->timestamp;

        $mostAnticipatedUnformatted = $this->mostAnticipated =  Game::select([
            'name' ,
            'first_release_date',
            'summary',
            'slug',


        ])
        ->with(['cover' => '*','platforms' => 'abbreviation'])
        ->where([
            ['platforms' , [48,49,130,6]],
            ['first_release_date' , '>=' , $current],
            ['first_release_date' , '<', $afterFourMonths],

        ])
        ->take(4)
        ->orderBy('rating_count', 'asc')
        ->get();

        $this->mostAnticipated = $this->formatForView($mostAnticipatedUnformatted);

    }

    public function render()
    {
        return view('livewire.most-anticipated');
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
