<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Guest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter values from the request
        $checkInDate = $request->get('check_in');
        $checkOutDate = $request->get('check_out');
        $year = $request->get('year');
        $month = $request->get('month');

        // Only fetch data if filters are set
        $reports = collect(); // Empty collection
        $groupedReports = [];
        $monthlyTotals = [];

        if ($checkInDate || $checkOutDate || $year || $month) {
            $query = Booking::latest();

            if ($checkInDate && $checkOutDate) {
                $query->whereDate('check_in', '>=', $checkInDate)
                    ->whereDate('check_out', '<=', $checkOutDate);
            }

            if ($year && $month) {
                $query->whereYear('check_in', $year)
                    ->whereMonth('check_in', $month);
            }

            $reports = $query->get();

            // Group reports and calculate monthly totals
            foreach ($reports as $report) {
                $monthYear = \Carbon\Carbon::parse($report->check_in)->format('Y-m'); 
                $currency = session('currency', 'USD');
                $exchangeRate = 4100;
                $pricePerDay = $report->room->roomType->price;
                $days = \Carbon\Carbon::parse($report->check_in)->diffInDays($report->check_out);
                $total = $pricePerDay * $days;

                if ($currency == 'KHR') {
                    $total *= $exchangeRate;
                }

                if (!isset($groupedReports[$monthYear])) {
                    $groupedReports[$monthYear] = [];
                }
                $groupedReports[$monthYear][] = $report;

                if (!isset($monthlyTotals[$monthYear])) {
                    $monthlyTotals[$monthYear] = 0;
                }
                $monthlyTotals[$monthYear] += $total;
            }
        }

        $bookings = Booking::all();

        // Other logic (e.g., counts, recent users, etc.)
        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();  
        $checkOutCount = Booking::where('status', 'check_out')->count();  
        $users = User::count();

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $customers = Customer::get();

        return view('admin.reports.report', [
            'customers' => $customers,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'groupedReports' => $groupedReports,
            'monthlyTotals' => $monthlyTotals,
            'websiteBookingCount' => $websiteBookingCount
        ]);        
    }
}
