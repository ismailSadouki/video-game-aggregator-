<div wire:init="loadPopularGames" class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16 ">
          
    @forelse ($popularGames as $game)      
       <x-game-card :game="$game" />
       
    @empty 
        
        @foreach (range(1, 12) as $game)
            <x-game-card-skeleton />
        @endforeach
       
    @endforelse

</div> <!-- end popular-games -->

@push('scripts')
               
    {{-- <script>
            console.log('A post ws: ' + params.slug);
        });
    </script> --}}
     @include('_rating', [
        'event' => 'gameWithRatingAdded',
    ])

@endpush