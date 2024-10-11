<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Hall;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Movie::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = Storage::disk('public')->putFile('posters', $request->file('file'));
            $input = $request->validated();
            unset($input['file']);
            $input['poster_url'] = asset("storage/$path");
        } else {
            $input = $request->validated();
        }

        return Movie::query()->create($input);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $MovieId)
    {
        return Movie::query()->findOrFail($MovieId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieRequest $request, int $movieId)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = Storage::disk('public')->putFile('posters', $request->file('file'));
            $input = $request->validated();
            unset($input['file']);
            $input['poster_url'] = asset("storage/$path");
        } else {
            $input = $request->validated();
        }

        $movie = Movie::query()->findOrFail($movieId);
        $movie->fill($input);

        return $movie->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $MovieId)
    {
        $movie = Movie::query()->findOrFail($MovieId);
        $seances = $movie->seances();
        $seances->delete();
        if ($movie->delete()) {
            return response(null, 204);
        }
        return null;
    }

    /**
     * Функция возвращает подходящие по дате, имеющие сеансы в доступных залах, фильмы.
     */
    public function getMoviesAvailable(string $date) {
        $movies = Movie::where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->has('seances')
            ->get();

        $halls = Hall::has('seances')->where('sales', true)->get();

        $availableMovies = [];

        foreach($movies as $movie) {
            foreach($halls as $hall) {
                if ($movie->seances()->where('hall_id', $hall->id)->exists()) {
                    if (!in_array($movie, $availableMovies)) {
                        $availableMovies[] = $movie;
                    }
                }
            }
        }
        return $availableMovies;
    }
}
