<?php

namespace App\Http\Controllers\Webfront;

use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $roomType = RoomType::with(['amenities', 'rooms'])->findOrFail($id);
        $roomTypes = RoomType::all();
        $relatedRoomTypes = RoomType::where('id', '!=', $id)->take(4)->get();
        $customers = \App\Models\Customer::all();

        $roomTypes = RoomType::all(); 

        // Fetch bookings with status 'Website'
        $bookings = Booking::where('status', 'Pending')
            ->where('booking_source', 'Website')
            ->whereHas('room', function ($query) use ($id) {
                $query->where('room_type_id', $id);
            })
            ->with('customer', 'room.roomType')
            ->get();

        return view('web_frontend.frontwebs.viewroom', [
            'roomType' => $roomType,
            'relatedRoomTypes' => $relatedRoomTypes,
            'roomTypes' => $roomTypes,
            'bookings' => $bookings,
            'customers' => $customers
        ]);
    }
    public function create()
    {

        $customers = \App\Models\Customer::all();

        $roomTypes = \App\Models\RoomType::all();

        return view('viewrooms.create', compact('customers', 'roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0',
            'room_id' => 'required|exists:rooms,id',
            'room_type_id' => 'required|exists:room_types,id',
            'gender' => 'nullable|string|in:male,female,other',
            'address' => 'nullable|string',
            'child' => 'nullable|integer|min:0',
            'adult' => 'nullable|integer|min:0',
            'number_of_rooms' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($request->room_id);
        $roomType = $room->roomType;

        // Check if the room is already booked on the same check-in date with the same room room_number and floor
        $existingBooking = Booking::where('check_in', $request->check_in)
            ->whereHas('room', function ($query) use ($room) {
                $query->where('room_number', $room->room_number)
                    ->where('floor', $room->floor);
            })
            ->first();

        if ($existingBooking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This room is already booked on the selected date. Please select a new date.📅👌😘');
        }

        // Create new customer only if there is no conflicting booking
        $customer = \App\Models\Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address
        ]);

        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $roomType->price;

        // Create the booking
        $booking = Booking::create([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'number_of_adults' => $request->number_of_adults,
            'number_of_children' => $request->number_of_children,
            'number_of_rooms' => $request->number_of_rooms,
            'total_price' => $totalPrice,
            'status' => 'Pending',
            'booking_source' => 'Website',
            'booking_reference' => 'BK' . strtoupper(Str::random(8)),
        ]);

        return redirect()->route('invoices.index', $booking->id)
            ->with('status', 'Booking successful.');
    }

}
