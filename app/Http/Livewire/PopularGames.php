<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Str;

class PopularGames extends Component
{
    public $popularGames = [];

    public function loadPopularGames()
    {
        $before = Carbon::now()->subMonth(12)->timestamp;
        $after = Carbon::now()->addMonth(12)->timestamp;

        $popularGamesUnformatted = Cache::remember('popular-games', 7, function() use($before, $after){
            // sleep(3);
            return Http::withHeaders(config('services.igdb.headers'))
            ->withBody(
                "fields name, cover.url, first_release_date,  total_rating_count, platforms.abbreviation,rating, rating_count, slug;
                    where platforms = (48,46,130,6)
                    &  total_rating_count != null
                    & rating != null
                    &  total_rating_count > 20
                    & (first_release_date >= {$before}
                    & first_release_date < {$after});
                    sort first_release_date asc;
                    sort  total_rating_count desc;
                    limit 12;",'text/plain')
            ->post(config('services.igdb.endpoint'))
            ->json();
        });
        

        $this->popularGames = $this->formatForView($popularGamesUnformatted);
        
        collect($this->popularGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('gameWithRatingAdded', [
                'slug' => $game['slug'],
                'rating' => $game['rating'] / 100
            ]);
        });
    }

    public function render()
    {
        return view('livewire.popular-games');
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
                'rating' => isset($game['rating']) ? round($game['rating']) : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            ]);
        })->toArray();
    }
}
