<div class="relative" x-data="{isVisible: true}" @click.away="isVisible = false">
    <input 
      wire:model.debounce.300ms="search"
      type="text"
      class="bg-gray-800 text-sm rounded-full px-3 w-64 py-1 focus:outline-none pl-8 focus:shadow-outline " 
      placeholder="Search (Press '/' to focus)"
      x-ref="search"
      @keydown.window="
        if(event.keyCode === 191) {
            event.preventDefault();
            $refs.search.focus();
        }
      "
      @focus="isVisible = true" 
      @keydown.escape.window = "isVisible = false"
      @keydown="isVisible = true"
      @keydown.shift.tab="isVisible = false"
    >
    <div class="absolute top-0 flex items-center h-full ml-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="fill-current text-gray-400 w-4 bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
    </div>

    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3" style="position: absolute"></div>

    @if (strlen($search) >= 2)
        
    <div class="absolute z-50 bg-gray-800 text-xs rounded w-64 mt-2" x-show.transition.opacity.duration.1000="isVisible">
        @if (count($searchResults) > 0 )
            
        <ul>
            @foreach ($searchResults as $game)
                <li class="border-b border-gray-700">
                    <a
                        href="{{ route('games.show', $game['slug']) }}" 
                        class="block hover:bg-gray-700 flex items-center transition ease-in-out duration-150 px-3 py-3"
                        @if ($loop->last)
                            @keydown.tab="isVisible = false"
                        @endif    
                    >
                        @if (isset($game['cover']))
                            <img src="{{ Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) }}" alt="cover" class="w-10">
                        @endif
                        <span class="ml-4">{{ $game['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        @else 
            <div class="px-3 py-3">No Results for "{{$search}}"</div>
        @endif

    </div>
    @endif

</div>