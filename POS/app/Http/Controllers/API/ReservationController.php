<?php

namespace App\Http\Controllers\API;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user', 'tableResto')->get();
        return response()->json($reservations);
    }

    public function userReservations(Request $request)
    {
        return response()->json($request->user()->reservations()->with('tableResto')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'nombre_personnes' => 'required|integer|min:1',
            'table_resto_id' => 'required|exists:table_restos,id',
        ]);

        $reservation = $request->user()->reservations()->create($request->all());

        return response()->json($reservation, 201);
    }

    public function show(Reservation $reservation)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'manager' && $reservation->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($reservation->load('user', 'tableResto'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        // يمكن للمالك أو المدير تعديل الحجز
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'manager' && $reservation->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'date' => 'sometimes|date',
            'heure' => 'sometimes|date_format:H:i',
            'nombre_personnes' => 'sometimes|integer|min:1',
            'statut' => 'sometimes|string|in:confirmée,annulée,terminée',
        ]);

        $reservation->update($request->all());

        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        // يمكن للمالك أو المدير حذف الحجز
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'manager' && $reservation->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $reservation->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}