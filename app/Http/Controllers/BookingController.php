<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index(Request $request)
    {

        $filters = $request->only(['customer_name', 'check_in', 'check_out', 'status']);

        $bookings = Booking::with(['customer', 'room', 'room.roomType'])
            ->filter($filters)
            ->latest()
            ->paginate(10);

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $booking_count = Booking::count();
        $checkInCount = Booking::whereDate('check_in', Carbon::today())->count();
        $checkOutCount = Booking::whereDate('check_out', Carbon::today())->count();

        $users = User::count();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        return view('admin.bookings.booking_record', compact(
            'bookings',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'users',
            'filters',
            'websiteBookingCount',
        ));
    }

    public function create(Request $request)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $customers = Customer::all();
        $roomTypes = RoomType::all();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->whereDate('created_at', today())
            ->count();

        $rooms = Room::where('status', 'available')->get();

        $customer_id = $request->query('customer_id');

        return view('admin.bookings.create', compact(
            'customers',
            'rooms',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'roomTypes',
            'websiteBookingCount',
            'customer_id'
        ));
    }

    public function period(Request $request)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->whereDate('created_at', today())
            ->count();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Booking::query();

        if ($startDate) {
            $query->whereDate('check_in', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('check_out', '<=', $endDate);
        }

        $bookings = $query->get();

        return view('admin.bookings.booking_record', compact(
            'bookings',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'websiteBookingCount'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0',
            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,confirmed,canceled',
            'description' => 'nullable|string',
            'booking_source' => 'required|string',
            'booking_reference' => 'nullable|string',
            'number_of_rooms' => 'required|integer|min:1',
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
            'number_of_adults' => $request->number_of_adults,
            'number_of_children' => $request->number_of_children,
            'total_price' => $request->total_price,
            'status' => $request->status ?? 'confirmed', // Default status
            'description' => $request->description,
            'booking_source' => $request->booking_source,
            'booking_reference' => $request->booking_reference,
            'number_of_rooms' => $request->number_of_rooms
        ]);

        // Update room status to "booked"
        $room->update(['status' => 'booked']);

        return redirect('bookings')->with('status', 'Booking created successfully!');
    }

    public function show(Booking $booking)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->whereDate('created_at', today())
            ->count();

        return view('admin.bookings.show', compact(
            'booking',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'websiteBookingCount'
        ));
    }

    public function edit(Booking $booking)
    {
        // Fetch necessary data
        $customers = Customer::all();
        $rooms = Room::with('roomType')->get();

        if (!$booking) {
            return redirect()->route('bookings.index')->withErrors(['error' => 'Booking not found.']);
        }

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
        ->whereDate('created_at', today())
        ->count();

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        return view('admin.bookings.edit', compact(
            'booking',
            'customers',
            'rooms',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'websiteBookingCount'
        ));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return redirect('bookings')->with('status', 'Booking updated successfully!');
    }


    public function checkIn($id)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->whereDate('created_at', today())
            ->count();

        $booking = Booking::findOrFail($id);

        // Ensure booking is in confirmed status
        if ($booking->status !== 'confirmed') {
            return redirect('bookings')
                ->with('error', 'This booking cannot be checked in.');
        }

        return view('admin.bookings.check-in', compact(
            'booking',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'websiteBookingCount'
        ));
    }

    public function processCheckIn(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure booking is in confirmed status
        if ($booking->status !== 'confirmed') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking cannot be checked in.');
        }

        // Update booking status and actual check-in time
        $booking->status = 'checked_in';
        $booking->actual_check_in = Carbon::now();
        $booking->save();

        // Update room status to occupied
        $room = Room::find($booking->room_id);
        $room->status = 'booked';
        $room->save();

        return redirect()->route('bookings.show', $booking)
            ->with('status', 'Customer checked in successfully.');
    }

    public function checkOut($id)
    {

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        /**
         * Handle the check-in for a booking.
         *
         * @param int $id Booking ID
         *
         * @return \Illuminate\Http\Response
         */
        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->whereDate('created_at', today())
            ->count();


        $booking = Booking::with(['customer', 'room', 'room.roomType', 'payments'])
            ->findOrFail($id);

        // Ensure booking is in checked_in status
        if ($booking->status !== 'checked_in') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking cannot be checked out.');
        }

        // Update room status to occupied
        $room = Room::find($booking->room_id);
        $room->status = 'available';
        $room->save();

        return view('admin.bookings.check-out', compact(
            'booking',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'websiteBookingCount'
        ));
    }

    public function processCheckOut(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure booking is in checked_in status
        if ($booking->status !== 'checked_in') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking cannot be checked out.');
        }

        // Update booking status and actual check-out time
        $booking->status = 'checked_out';
        $booking->actual_check_out = Carbon::now();
        $booking->save();

        // Update room status to available
        $room = Room::find($booking->room_id);
        $room->status = 'available';
        $room->save();

        return redirect()->route('bookings.show', $booking)
            ->with('status', 'Customer checked out successfully.');
    }

    public function confirm(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure booking is in a status that can be confirmed
        if (!in_array($booking->status, ['pending', 'reserved'])) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking cannot be confirmed.');
        }

        // Update booking status to confirmed
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('bookings.show', $booking)
            ->with('status', 'Booking confirmed successfully.');
    }


    public function cancel(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        // Ensure booking is in a status that can be cancelled
        if (!in_array($booking->status, ['pending', 'confirmed', 'reserved'])) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking cannot be cancelled.');
        }

        // Update booking status to cancelled
        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('bookings.show', $booking)
            ->with('status', 'Booking cancelled successfully.');
    }

    public function checkRoomAvailability(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $roomId = $request->room_id;
        $checkInDate = $request->check_in;
        $checkOutDate = $request->check_out;

        // Check for overlapping bookings
        $overlappingBookings = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 1: Existing booking starts within the new booking period
                    $q->whereBetween('check_in', [$checkInDate, $checkOutDate]);
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 2: Existing booking ends within the new booking period
                    $q->whereBetween('check_out', [$checkInDate, $checkOutDate]);
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 3: Existing booking completely covers the new booking period
                    $q->where('check_in', '<=', $checkInDate)
                    ->where('check_out', '>=', $checkOutDate);
                })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                    // Case 4: New booking completely covers an existing booking period
                    $q->where('check_in', '>=', $checkInDate)
                    ->where('check_out', '<=', $checkOutDate);
                });
            })
            ->exists();

        if ($overlappingBookings) {
            return response()->json(['error' => 'Room is not available for the selected dates'], 400);
        }

        return response()->json(['success' => 'Room is available']);
    }

    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);

        if (in_array($booking->status, ['confirmed', 'checked_in','pending', 'reserved','cancelled'])) {
            $room = Room::find($booking->room_id);
            if ($room) {
                $room->update(['status' => 'available']);
            }
        }
        $booking->delete();

        return redirect('bookings')->with('status', 'Booking deleted successfully and room released.');
    }
}
