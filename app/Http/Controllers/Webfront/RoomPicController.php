<?php

namespace App\Http\Controllers\Webfront;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class RoomPicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Paginator::useBootstrap();

        // Paginate the RoomType query
        $roomtypes = RoomType::with(['rooms.bookings'])->paginate(8);

        return view('web_frontend.frontwebs.roompic', [
            'roomtypes' => $roomtypes,
        ]);
    }

    public function search(Request $request)
    {
        $query = RoomType::with('rooms');

        $checkIn = $request->input('check_in') ? Carbon::parse($request->input('check_in')) : null;
        $checkOut = $request->input('check_out') ? Carbon::parse($request->input('check_out')) : null;
        $minPrice = $request->input('min_price');
        $adults = $request->input('adults');
        $child = $request->input('child');

        if ($checkIn && $checkOut) {
            $bookedRoomIds = Booking::where(function ($query) use ($checkIn, $checkOut) {
                $query->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })->pluck('room_id');

            $query->whereHas('rooms', function ($query) use ($bookedRoomIds) {
                $query->whereNotIn('id', $bookedRoomIds);
            });
        }

        if ($adults) {
            $query->where('adult', '>=', $adults);
        }

        if ($child) {
            $query->where('child', '>=', $child);
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        $roomtypes = $query->paginate(8);

        if ($roomtypes->isEmpty()) {
            return back()->with('alert', trans('menu.no_available_rooms'))->withInput();
        }

        Paginator::useBootstrap();

        return view('web_frontend.frontwebs.roompic', compact('roomtypes'));
    }

}
