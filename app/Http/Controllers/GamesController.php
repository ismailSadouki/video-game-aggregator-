<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Game;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $game = $this->popularGames =  Game::select([
            'name' ,
            'first_release_date',
            'rating',
            'slug',
            'aggregated_rating',
            'summary',
            
            
        ])
        ->with([
            'cover' => '*',
            'platforms' => 'abbreviation',
            'genres' => 'name',
            'websites' => '*',
            'videos' => 'video_id',
            'screenshots' => '*',

        ])
        ->where('slug',$slug)
        ->first();

        abort_if(!$game,404);

        return view('show', [
            'game' => $this->formatGameForView($game),
        ]);

        
    }

    private function formatGameForView($game) 
    {
        return collect($game)->merge([
            'coverImageUrl' => Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']),
            'genres' => collect($game['genres'])->pluck('name')->implode(', '),
            'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            'memberRating' => isset($game['rating']) ? round($game['rating']) : '0',
            'criticRating' => isset($game['aggregated_rating']) ? round($game['aggregated_rating']) : '0',
            'summary' => Str::limit($game['summary'], 1000, '...'),
            'trailer' => isset($game['videos']) ? 'https://youtube.com/embed/'.$game['videos'][0]['video_id'] : null,
            'screenshots' => collect($game['screenshots'])->map( function ($screenshot) {
                return [
                    'big' => Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url']) ,
                    'huge' => Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url'])
                ];
            })->take(9),
            'social' => [
                'website' => collect($game['websites'])->first(),
                'facebook' => collect($game['websites'])->filter( function ($website) {
                    return str::contains($website['url'],'facebook');
                })->first(),
                'twitter' => collect($game['websites'])->filter( function ($website) {
                    return str::contains($website['url'],'twitter');
                })->first(),
                'instagram' => collect($game['websites'])->filter( function ($website) {
                    return str::contains($website['url'],'instagram');
                })->first(),
            ] 
        ]);
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
