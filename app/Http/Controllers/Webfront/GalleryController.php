<?php

namespace App\Http\Controllers\Webfront;

use App\Models\Room;
use App\Models\Gallery;
use App\Http\Controllers\Controller;  // Correct import for base Controller
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        // Booking statistics and other variables
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
    
        // Return the view with the galleries and other data
        return view('admin.gallery.index', [
            'galleries' => $galleries, // Make sure this is correctly passed
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id') // Use customer_id or any unique field representing a user
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

        return view('admin.gallery.create',[
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings, // Pass booking records
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $validatedData['image'] = $path;
        }
        Gallery::create($validatedData);

        return redirect('galleries')->with('status', 'Gallery item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the gallery item by its ID
        $gallery = Gallery::findOrFail($id);  // This fetches the gallery item by ID

        // Booking statistics
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')  // Count distinct guest emails in the last 7 days
            ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $booking_count = Booking::count();  // Total count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();  // Count of checked-in bookings
        $checkOutCount = Booking::where('status', 'check_out')->count();  // Count of checked-out bookings
        $bookings = Booking::latest()->take(5)->get();  // Get the latest 5 booking records
        $users = User::count();  // Total count of users

        // Return the view with all data
        return view('admin.gallery.show', [
            'gallery' => $gallery,  // Pass the gallery item to the view
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,  // Pass the latest booking records
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $gallery = Gallery::findOrFail($id);  // Eager load the images
        // Booking statistics
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')  // Count distinct guest emails in the last 7 days
            ->count('customer_id');
        
        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $booking_count = Booking::count();  // Total count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();  // Count of checked-in bookings
        $checkOutCount = Booking::where('status', 'check_out')->count();  // Count of checked-out bookings
        $bookings = Booking::latest()->take(5)->get();  // Get the latest 5 booking records
        $users = User::count();  // Total count of users

        return view('admin.gallery.edit',[
            'gallery' => $gallery,  // Pass the gallery item to the view
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,  // Pass the latest booking records
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
   // Handle the form submission to update the gallery
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Main image
        ]);

        // Find the gallery by its ID
        $gallery = Gallery::findOrFail($id);

        // Update gallery details
        $gallery->name = $request->input('name');
        $gallery->description = $request->input('description');
        $gallery->price = $request->input('price');

        // Handle the main image upload
        if ($request->hasFile('image')) {
            $gallery->image = $request->file('image')->store('gallery_images', 'public');
        }

        // Save gallery changes
        $gallery->save();

        // Handle additional images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $gallery->images()->create([
                    'path' => $image->store('gallery_images', 'public'),
                ]);
            }
        }

        // Redirect to the gallery show page with a success message
        return redirect('galleries')->with('status', 'Gallery updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($galleryid)
    {
        $gallery = Gallery::findOrfail($galleryid);
        $gallery->delete();
        
        return redirect('galleries')->with('status','Gallery item deleted successfully.');
    }
}
