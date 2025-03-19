<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource for DataTable.
     */
    public function index(Request $request)
    {
        $query = Room::with('roomType');
        
        // Filter by room number if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('room_number', 'like', "%{$search}%");
        }
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by room type if provided
        if ($request->has('room_type_id') && $request->room_type_id) {
            $query->where('room_type_id', $request->room_type_id);
        }
        
        // Filter by floor if provided
        if ($request->has('floor') && $request->floor) {
            $query->where('floor', $request->floor);
        }
        
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $rooms = Room::all();
        $roomTypes = RoomType::all();
        $floors = Room::select('floor')->distinct()->orderBy('floor')->pluck('floor');

        return view('admin.rooms.index', compact('roomTypes','websiteBookingCount','rooms', 'floors', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $roomTypes = RoomType::where('is_active', true)->get();
        

        // Create an empty Room model instance
        $room = new Room();

        return view('admin.rooms.create', compact(
            'roomTypes', 'room',
            'recent_users_count', 'booking_count', 
            'checkInCount', 'checkOutCount', 'bookings', 'users',
            'websiteBookingCount'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|string|max:10',
            'status' => 'required|in:available,booked,maintenance,cleaning',
            'description' => 'nullable|string',
        ]);
    
        Room::create($validated);
        
        return redirect('rooms')
            ->with('status', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();


        $room = Room::with(['roomType', 'bookings.customer'])->findOrFail($id);
        
        // Get upcoming bookings for this room
        $upcomingBookings = $room->bookings()
            ->where('check_in', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->orderBy('check_in')
            ->take(5)
            ->get();
        
        // Get recent bookings for this room
        $recentBookings = $room->bookings()
            ->where('check_out', '<', now())
            ->orderBy('check_out', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.rooms.show', compact('room','websiteBookingCount', 'upcomingBookings', 'recentBookings', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
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
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $room = Room::findOrFail($id);
        $roomTypes = RoomType::where('is_active', true)->get();
        
        return view('admin.rooms.edit', compact('room','websiteBookingCount', 'roomTypes', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);
        
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|string|max:10',
            'status' => 'required|in:available,booked,maintenance,cleaning',
            'description' => 'nullable|string',
        ]);

        // Log the status value for debugging
        Log::info('Updating room status:', ['status' => $validated['status']]);

        $room->update($validated);
        
        return redirect('rooms')->with('status', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        
        // Check if room has bookings
        if ($room->bookings()->count() > 0) {
            return redirect()->route('rooms.show', $room)
                ->with('error', 'Cannot delete room with existing bookings.');
        }
        
        $room->delete();
        
        return redirect('rooms')
            ->with('status', 'Room deleted successfully.');
    }
}

