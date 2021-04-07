<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Game;


class RecentlyReviewd extends Component
{

    public $recentlyReviewed = [];
    public function loadRecentlyReviewd()
    {
        $recentlyReviewedUnformatted = $this->recentlyReviewed =  Game::select([
            'name' ,
            'first_release_date',
            'platforms',
            'rating',
            'rating_count',
            'summary',
            'slug'

        ])
        ->with(['cover' => '*','platforms' => 'abbreviation'])
        ->where([
            ['platforms' , [48,49,130,6]],

        ])
        ->take(3)
        ->orderBy('rating_count', 'desc')
        ->get();

        $this->recentlyReviewed = $this->formatForView($recentlyReviewedUnformatted);
    }
    public function render()
    {
        return view('livewire.recently-reviewd');
    }

    private function formatForView($games) 
    {
        return collect($games)->map( function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => isset($game['rating']) ? round($game['rating']).'%' : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
                'summary' => Str::limit($game['summary'], 200, '...'),
            ]);
        })->toArray();
    }
}
