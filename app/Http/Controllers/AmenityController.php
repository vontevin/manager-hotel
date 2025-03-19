<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Booking;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

        $amenities = Amenity::all();
        
        return view('admin.amenity.index', compact('amenities', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users', 'websiteBookingCount'));
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

        $amenities = Amenity::all();

        return view('admin.amenity.create',[
            'recent_users_count' => $recent_users_count,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'users' => $users,
            'amenities' => $amenities,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $amenity = Amenity::create($request->only(['name', 'description']));

        $roomData = $request->all();
        // $room = Room::create($roomData);

        // // Sync the amenities through the room's room type
        // $room->amenities()->sync($request->input('amenities', []));

        return redirect('amenities')->with('status', 'Amenity and Room created successfully!');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amenity $amenity)
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

        return view('admin.amenity.edit', compact('amenity','websiteBookingCount', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Amenity $amenity, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $room->update($request->all());

        // Sync the amenities through the room's room type
        // $room->amenities()->sync($request->input('amenities', []));
        
        $amenity->update($request->only(['name', 'description']));

        return redirect()->route('amenities.index')->with('status', 'Amenity updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        return redirect()->route('amenities.index')->with('status', 'Amenity deleted successfully!');
    }
}
