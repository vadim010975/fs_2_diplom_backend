<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChairRequest;
use App\Http\Requests\UpdateChairsByHallRequest;
use App\Http\Requests\UpdateChairsByIdRequest;
use App\Models\Chair;
use App\Models\Hall;
use App\Models\Seance;

class ChairController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ChairRequest $request)
    {
        $chairs = $request->validated()['chairs'];
        $array = [];
        foreach ($chairs as $chair) {
            $item = [
                'hall_id' => $chair['hall_id'],
                'row' => $chair['row'],
                'place' => $chair['place'],
                'type' => $chair['type'],
            ];
            $array[] = Chair::query()->create($item);
        }
        return  $array;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $ChairId)
    {
        return Chair::query()->findOrFail($ChairId);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChairsByHallRequest $request, int $hallId)
    {
        Hall::query()->findOrFail($hallId)->chairs()->delete();
        $chairs = $request->validated()['chairs'];
        $array = [];
        foreach ($chairs as $chair) {
            $item = [
                'hall_id' => $hallId,
                'row' => $chair['row'],
                'place' => $chair['place'],
                'type' => $chair['type']
            ];
            $array[] = Chair::query()->create($item);
        }
        return  $array;
    }

    public function updateChairs(UpdateChairsByIdRequest $request)
    {
        $chairs = $request->validated()['chairs'];
        $array = [];
        foreach($chairs as $chair) {
            $currentChair = Chair::query()->findOrFail($chair['id']);
            $currentChair->fill($chair);
            $array[] = $currentChair->save();
        }
        return  $array;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hall_id)
    {
        if (Chair::query()->where('hall_id', $hall_id)->doesntExist()) {
            return abort(404);
        }
        Chair::query()->where('hall_id', $hall_id)->delete();
    }

    /**
     * Получить занятые места по seance_id и date.
     */
    public function getBySeanceIdAndDate(int $SeanceId, string $Date)
    {
        return Seance::query()
            ->findOrFail($SeanceId)
            ->tickets()
            ->where('date', $Date)
            ->pluck('chair_id')
            ->toArray();
    }
}
