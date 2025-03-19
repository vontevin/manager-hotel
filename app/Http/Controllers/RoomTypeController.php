<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();

        $query = RoomType::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $roomTypes = $query->orderBy('name')->paginate(10);
        $roomTypes = RoomType::all();

        return view('admin.roomtypes.index', compact(
            'roomTypes', 'recent_users_count', 'booking_count','websiteBookingCount', 'checkInCount', 'checkOutCount', 'bookings'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $amenities = Amenity::all();
        
        // Set $roomType as null to avoid undefined variable error in the view
        $roomType = null;

        return view('admin.roomtypes.create', compact(
            'recent_users_count', 'booking_count','websiteBookingCount', 'checkInCount', 'checkOutCount', 'bookings', 'amenities', 'roomType'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'child' => 'nullable|integer|min:0',
            'adult' => 'required|integer|min:0',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5MB
            'is_active' => 'nullable|boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        // Create room type
        $roomType = RoomType::create($validated);

        // Attach selected amenities
        if ($request->hasFile('image')) {
            $image = $request->file('image');
        
            // Check file size manually
            if ($image->getSize() > 10 * 1024 * 1024) { // 10MB limit
                return back()->withErrors(['image' => 'The image size must not exceed 10MB.']);
            }
        
            $roomType->image = $image->store('room-types', 'public');
            $roomType->save();
        }

        if ($request->has('amenities')) {
            $roomType->amenities()->sync($request->amenities);
        }

        return redirect('roomtypes')->with('status', 'Room type created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(RoomType $roomType)
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

        // No need to fetch RoomType again
        $roomType->load('amenities');

        return view('admin.roomtypes.show', compact('roomType',
            'recent_users_count', 'booking_count','websiteBookingCount', 'checkInCount', 'checkOutCount', 'bookings', 'users'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the room type by ID
        $roomType = RoomType::with('amenities')->findOrFail($id);

        // Fetch all available amenities
        $amenities = Amenity::all();

        // Fetch the IDs of selected amenities
        $selectedAmenities = $roomType->amenities->pluck('id')->toArray();

        // Additional data
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();

        return view('admin.roomtypes.edit', compact(
            'roomType', 'amenities', 'selectedAmenities', 
            'recent_users_count', 'booking_count', 
            'checkInCount', 'checkOutCount', 'bookings',
            'websiteBookingCount'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the room type by its ID
        $roomType = RoomType::findOrFail($id);

        // Validate input with unique check on the name, excluding the current record
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:room_types,name,' . $id, // Unique validation excluding the current room type
            'price' => 'required|numeric|min:0',
            'adult' => 'required|integer|min:0',
            'child' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'amenities' => 'nullable|array',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Store the new image and get its path
            $imagePath = $request->file('image')->store('room_images', 'public');

            // If the room type already has an image, delete the old one
            if ($roomType->image) {
                Storage::disk('public')->delete($roomType->image);
            }

            // Add the new image path to validated data
            $validatedData['image'] = $imagePath;
        }

        // Update the room type with the validated data
        $roomType->update($validatedData);

        // Sync amenities (if any)
        if ($request->has('amenities')) {
            $roomType->amenities()->sync($request->amenities);
        }

        // Redirect back to the room types list with a success message
        return redirect()->route('roomtypes.index')->with('status', 'Room type updated successfully');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $roomType = RoomType::findOrFail($id);
        if ($roomType->rooms()->count() > 0) {
            return redirect()->route('roomtypes.index')->with('error', 'Cannot delete room type with existing rooms.');
        }

        if ($roomType->image) {
            Storage::disk('public')->delete($roomType->image);
        }

        $roomType->delete();

        return redirect()->route('roomtypes.index')->with('status', 'Room type deleted successfully.');
    }
}
