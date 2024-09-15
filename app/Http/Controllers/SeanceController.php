<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeanceRequest;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Seance;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Seance::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeanceRequest $request)
    {
        return Seance::query()->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $seanceId)
    {
        $seance = Seance::query()->findOrFail($seanceId);
        $movie = Movie::query()->findOrFail($seance->movie_id);
        $hall = Hall::query()->findOrFail($seance->hall_id);
        return [
            'seance' => $seance,
            'movie' => $movie,
            'hall' => $hall,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeanceRequest $request, int $seanceId)
    {
        $seance = Seance::query()->findOrFail($seanceId);
        $seance->fill($request->validated());
        return $seance->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $seanceId)
    {
        $seances = Seance::query()->findOrFail($seanceId);
        if ($seances->delete()) {
            return response(null, 204);
        }
        return null;
    }

    public function deleteAll(int $movieId)
    {
        $seances = Movie::query()->findOrFail($movieId)->seances();
        if ($seances->delete()) {
            return response(null, 204);
        }
        return null;
    }
}
