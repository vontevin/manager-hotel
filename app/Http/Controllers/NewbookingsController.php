<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class NewbookingsController extends Controller
{
    public function index()
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(1))
            ->distinct('customer_id')
            ->where('status', 'website')
            ->count('customer_id');

        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        
        return view('admin.NewBookings.index',[
            'recent_users_count' => $recent_users_count,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,            
            'bookings' => $bookings,
            'users' => $users,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }
}
