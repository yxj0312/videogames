<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class RecentlyReviewed extends Component
{  
    public $recentlyReviewed = [];

    public function loadRecentlyReviewed()
    {
        $before = Carbon::now()->subMonth(12)->timestamp;
        $current = Carbon::now()->timestamp;

        $this->recentlyReviewed = Http::withHeaders(config('services.igdb'))
        ->withBody(
            "fields name, cover.url, first_release_date, platforms.abbreviation,rating, rating_count, summary;
                where platforms = (48,46,130,6)
                & rating != null
                & rating_count > 20
                & (first_release_date >= {$before}
                & first_release_date < {$current});
                sort first_release_date asc;
                sort rating desc;
                limit 3;",'text/plain')
        ->post('https://api.igdb.com/v4/games/')
        ->json();
    }

    public function render()
    {
        return view('livewire.recently-reviewed');
    }
}
