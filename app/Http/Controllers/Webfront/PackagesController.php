<?php

namespace App\Http\Controllers\Webfront;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Package;  // Ensure you have a Package model

class PackagesController extends Controller
{
    /**
     * Display a listing of the packages.
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

        $packages = Package::all(); // Get all packages
        return view('admin.packages.index',[
            'packages' => $packages,
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
     * Show the form for creating a new package.
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

        return view('admin.packages.create',[
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);  // Return the package creation form view
    }

    /**
     * Store a newly created package in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('packages', 'public');
            $validatedData['image'] = $path;
        }

        // Create a new package record
        Package::create($validatedData);

        return redirect()->route('packages.index')->with('status', 'Package created successfully!');
    }

    /**
     * Display the specified package.
     */
    public function show(Package $package)
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
        return view('admin.packages.show',[
            'package' => $package,
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
     * Show the form for editing the specified package.
     */
    public function edit(Package $package)
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

        return view('admin.packages.edit',[
            'package' => $package,
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
     * Update the specified package in the database.
     */
    public function update(Request $request, Package $package)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,docx,zip|max:10240',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $imagePath = $request->file('image')->store('packages/images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Handle File Upload
        if ($request->hasFile('file')) {
            if ($package->file) {
                Storage::disk('public')->delete($package->file);
            }
            $filePath = $request->file('file')->store('packages/files', 'public');
            $validatedData['file'] = $filePath;
        }

        // Update the package
        $package->update($validatedData);

        return redirect()->route('packages.index')->with('status', 'Package updated successfully!');
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy($packageid)
    {
        $package = Package::findOrfail($packageid);
        $package->delete();
        
        return redirect('packages')->with('status','Package item deleted successfully.');
    }
}
