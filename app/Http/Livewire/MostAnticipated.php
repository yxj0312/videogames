<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];
    

    public function loadMostAnticipated()
    {
        $current = Carbon::now()->timestamp;

        $afterFourMonths = Carbon::now()->addMonth(4)->timestamp;
        
        $this->mostAnticipated = Http::withHeaders(config('services.igdb'))
            ->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation,summary;
                    where platforms = (48,46,130,6)
                    & (first_release_date >= {$current}
                    & first_release_date < {$afterFourMonths});
                    sort first_release_date asc;
                    limit 4;",'text/plain')
            ->post('https://api.igdb.com/v4/games/')
            ->json();
    }

    public function render()
    {
        return view('livewire.most-anticipated');
    }
}
