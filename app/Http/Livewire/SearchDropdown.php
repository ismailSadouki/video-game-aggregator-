<?php

namespace App\Http\Livewire;

use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Game;

class SearchDropdown extends Component
{
    public $search = '';
    public $searchResults = [];


    public function render()
    {
        if (strlen($this->search) >= 2) {
            $this->searchResults =  Game::search($this->search)->select([
                'name' ,
                'slug',
    
            ])
            ->with(['cover' => '*'])
            ->limit(8)
            ->get();
        }
        

        return view('livewire.search-dropdown');
    }
}
