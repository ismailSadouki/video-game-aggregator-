<div wire:init="loadRecentlyReviewd" class="recently-reiewd-container space-y-12 mt-8">
    @forelse ($recentlyReviewed as $game)
        <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
            <div class="relative flex-none">
                <a href="{{route('games.show', $game['slug'])}}">
                    <img src="{{ $game['coverImageUrl'] }}" alt="game cover" style="min-height: 256px;" class="w-48 min-w-full hover:opacity-75 transition ease-in-out duration-150">
                </a>
                @if (isset($game['rating']))
                    <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-900 rounded-full" style="right:-20px; bottom:-20px;">
                        <div class="font-semibold text-xs flex justify-center items-center h-full">
                            {{ $game['rating'] }}
                        </div>
                    </div>
                @endif
            </div>
            <div class="ml-12">
                <a href="{{route('games.show', $game['slug'])}}" class=" hidden md:block lg:block text-lg font-semibold leading-tight hover:text-gray-400 mt-4">
                    {{$game['name']}}
                </a>
                <div class="text-gray-400 mt-1 hidden md:block lg:block">
                            {{ $game['platforms']}}
                </div>
                <p class="mt-6 text-gray-400 hidden  lg:block">
                    {{ $game['summary'] }}
                </p>
            </div>
        </div>
    @empty 
        @foreach (range(1,3) as $game)
            <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
                <div class="relative flex-none">
                <div class="bg-gray-700 w-32 lg:w-48 h-40 lg:h-56"></div>
                
                </div>
                <div class="ml-12">
                    <div class="inline-block hidden md:inline-block lg:inline-block text-lg font-semibold leading-tight text-transparent bg-gray-700 rounded mt-4">
                        Title goes here
                    </div>
                
                    <div class="mt-8 space-y-4 hidden lg:block">
                        <span class="text-transparent bg-gray-700 inline-block">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        </span>
                        <span class="text-transparent bg-gray-700 inline-block">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        </span>
                        <span class="text-transparent bg-gray-700 inline-block">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        </span>
                    </div>
                </div>
            </div>   
        @endforeach 
    @endforelse

    


</div>