<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Str;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];
    

    public function loadMostAnticipated()
    {
        $current = Carbon::now()->timestamp;

        $afterFourMonths = Carbon::now()->addMonth(4)->timestamp;
        
        $mostAnticipatedUnformatted = Http::withHeaders(config('services.igdb'))
            ->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation,summary,slug;
                    where platforms = (48,46,130,6)
                    & (first_release_date >= {$current}
                    & first_release_date < {$afterFourMonths});
                    sort first_release_date asc;
                    limit 4;",'text/plain')
            ->post('https://api.igdb.com/v4/games/')
            ->json();

        $this->mostAnticipated = $this->formatForView($mostAnticipatedUnformatted);
    }

    public function render()
    {
        return view('livewire.most-anticipated');
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => Str::replaceFirst('thumb','cover_small', $game['cover']['url']),
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }
}
