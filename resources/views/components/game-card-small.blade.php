<div class="game flex">
@isset($game['cover'])
    <a href="{{ route('games.show', $game['slug']) }}"><img src="{{ $game['coverImageUrl'] }}" alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150"></a>
@endisset
@empty($game['cover'])
    <div class="bg-gray-800 w-16 h-20 flex-none"></div>
@endempty    
    <div class="ml-4">
        <a href="{{ route('games.show', $game['slug']) }}" class="hover:text-gray-300">{{ $game['name'] }}</a>
        <div class="text-gray-400 text-sm mt-1">{{ $game['releaseDate'] }}</div>
    </div>
</div>