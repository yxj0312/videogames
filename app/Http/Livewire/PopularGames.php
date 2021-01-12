<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PopularGames extends Component
{
    public $popularGames = [];

    public function loadPopularGames()
    {
        $before = Carbon::now()->subMonth(12)->timestamp;
  
        $after = Carbon::now()->addMonth(12)->timestamp;
        
        $this->popularGames = Http::withHeaders(config('services.igdb'))
        ->withBody(
            "fields name, cover.url, first_release_date, platforms.abbreviation,rating, rating_count, slug;
                where platforms = (48,46,130,6)
                & rating != null
                & rating_count > 20
                & (first_release_date >= {$before}
                & first_release_date < {$after});
                sort first_release_date asc;
                sort rating desc;
                limit 12;",'text/plain')
        ->post('https://api.igdb.com/v4/games/')
        ->json();
    }

    public function render()
    {
        return view('livewire.popular-games');
    }
}
