<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = Booking::query();
        
        $rooms = Room::all();  // Fetch all rooms from your database
        $room_types = RoomType::all();  // Fetch all room types
        $filters = $request->only(['customer', 'email', 'check_in', 'check_out']);

        // Other booking-related statistics
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $latest_bookings = Booking::all();
        $users = User::count();

        $minDate = Booking::min('check_in');
        $maxDate = Booking::max('check_out');

        $customers = Customer::all();

        return view('admin.BookEvents.event', [
            'bookings' => $latest_bookings,
            'events' => $bookings,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'rooms' => $rooms,
            'room_types' => $room_types,
            'filters' => $filters,
            'customers' => $customers,
            'minDate' => $minDate,
            'maxDate' => $maxDate,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }


    /**
     * Display filtered booking records.
     */
    public function showEvents(Request $request)
    {
        $bookings = Booking::query();

        // Filter by guest name if provided
        if ($request->filled('customer')) {
            $bookings->where('customer', 'like', '%' . $request->customer . '%');
        }

        // Filter by check-in date if provided
        if ($request->filled('check_in')) {
            $bookings->whereDate('check_in', '>=', $request->check_in);
        }

        // Filter by check-out date if provided
        if ($request->filled('check_out')) {
            $bookings->whereDate('check_out', '<=', $request->check_out);
        }

        $bookings = $bookings->get();

        return view('events', compact('bookings'));
    }

    /**
     * Store a newly created booking record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'number_of_guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,confirmed,canceled',
            'description' => 'nullable|string',
            'booking_source' => 'required|string',
            'booking_reference' => 'nullable|string',
        ]);
        
        // Ensure room is available
        $room = Room::find($request->room_id);
        if (!$room || $room->status != 'available') {
            return back()->withErrors(['room_id' => 'Selected room is not available.']);
        }

        // Create booking
        $booking = Booking::create([
            'customer_id' => $request->customer_id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'number_of_guests' => $request->number_of_guests,
            'total_price' => $request->total_price,
            'status' => $request->status ?? 'confirmed', // Default status
            'description' => $request->description,
            'booking_source' => $request->booking_source,
            'booking_reference' => $request->booking_reference,
        ]);

        // Update room status to "booked"
        $room->update(['status' => 'booked']);

        $event = $booking;

        return response()->json($event);
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.BookEvents.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.BookEvents.modals.event_edit', compact('booking'));
    }


    /**
     * Update an existing booking record.
     */
    public function update(Request $request, $id)
    {
        Log::info('Updating event with ID: ' . $id);
        
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'number_of_guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|in:confirmed,pending,canceled',
            'description' => 'nullable|string',
            'booking_source' => 'required|string',
            'booking_reference' => 'nullable|string',
        ]);

        $event = Booking::findOrFail($id);

        $event->customer_id = $request->customer_id;
        $event->room_id = $request->room_id;
        $event->check_in = \Carbon\Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $event->check_out = \Carbon\Carbon::parse($request->check_out)->format('Y-m-d H:i:s');
        $event->number_of_guests = $request->number_of_guests;
        $event->total_price = $request->total_price;
        $event->status = $request->status;
        $event->description = $request->description;
        $event->booking_source = $request->booking_source;
        $event->booking_reference = $request->booking_reference;

        $event->save();

        return response()->json($event);
    }
    
    /**
     * Delete a booking record.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking record deleted successfully']);
    }

    /**
     * Fetch booking records for FullCalendar.
     */
    public function calendarEvents(Request $request)
    {
        $bookings = Booking::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->customer->first_name . ' ' . $booking->customer->last_name,
                'start' => $booking->check_in,
                'end' => date('Y-m-d', strtotime($booking->check_out . '+1 days')), // Adjust end date to reflect check-out
                'customer_id' => $booking->customer_id,
                'room_id' => $booking->room_id,
                'room_number' => $booking->room->room_number,
                'room_floor' => $booking->room->floor,
                'number_of_guests' => $booking->number_of_guests,
                'total_price' => $booking->total_price,
                'status' => $booking->status,
                'description' => $booking->description,
                'booking_source' => $booking->booking_source,
            ];
        });

        return response()->json($bookings);
    }



    public function checkRoomAvailability($roomId, $checkInDate, $checkOutDate)
    {

        $existingBookings = Booking::where('room_id', $roomId)
                                ->where('check_in', '<', $checkOutDate)
                                ->where('check_out', '>', $checkInDate)
                                ->exists();

        return $existingBookings ? 'unavailable' : 'available';
    }

}
