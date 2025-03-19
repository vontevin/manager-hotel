<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\Booking;

class StaffController extends Controller
{
    public function index()
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id') // Use customer_id or any unique field representing a user
            ->count('customer_id');

        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();
        
        $staffs = Staff::all();
        return view('admin.staffs.index', compact('staffs','websiteBookingCount', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

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

        return view('admin.staffs.create', compact('recent_users_count','websiteBookingCount', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'required|string|max:20',
        ]);

        $staff = Staff::create($request->all()); // Store new staff

        return redirect()->route('staffs.index')->with('status', 'Staff created successfully!');
    }

    public function show($id)
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

        $staff = Staff::findOrFail($id);
        return view('admin.staffs.show', compact('staff','websiteBookingCount', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    public function edit($id)
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

        $staff = Staff::findOrFail($id);
        return view('admin.staffs.edit', compact('staff','websiteBookingCount', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        $staff = Staff::findOrFail($id);
        $staff->update($request->all());

        return redirect()->route('staffs.index')->with('status', 'Staff updated successfully!');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('staffs.index')->with('status', 'Staff deleted successfully!');
    }
}
