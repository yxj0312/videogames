<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $before = Carbon::now()->subMonth(12)->timestamp;
  
        $after = Carbon::now()->addMonth(12)->timestamp;

        $current = Carbon::now()->timestamp;

        $afterFourMonths = Carbon::now()->addMonth(4)->timestamp;


        $popularGames = Http::withHeaders(config('services.igdb'))
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

        $recentlyReviewed = Http::withHeaders(config('services.igdb'))
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


        $mostAnticipated = Http::withHeaders(config('services.igdb'))
            ->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation,summary;
                    where platforms = (48,46,130,6)
                    & (first_release_date >= {$current}
                    & first_release_date < {$afterFourMonths});
                    sort first_release_date asc;
                    limit 4;",'text/plain')
            ->post('https://api.igdb.com/v4/games/')
            ->json();


        $comingSoon = Http::withHeaders(config('services.igdb'))
            ->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation,summary;
                    where platforms = (48,46,130,6)
                    & (first_release_date >= {$current});
                    sort first_release_date asc;
                    limit 4;",'text/plain')
            ->post('https://api.igdb.com/v4/games/')
            ->json();

        return view('index', [
            'popularGames' => $popularGames,
            'recentlyReviewed' => $recentlyReviewed,
            'mostAnticipated' => $mostAnticipated,
            'comingSoon' => $comingSoon,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
