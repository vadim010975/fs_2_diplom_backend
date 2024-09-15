<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        if (Ticket::query()
            ->where('date', $request->get('date'))
            ->where('seance_id', $request->get('seance_id'))
            ->where('chair_id', $request->get('chair_id'))
            ->exists()) {
            return response('билет уже есть в базе данных', 400);
        }

        return Ticket::query()->create($request->validated());
    }
}
