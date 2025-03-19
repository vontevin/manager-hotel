<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Guest;
use App\Models\Gallery;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin|super-admin|manager|admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->autoCheckOut(); // Call the auto check-out function

        $years = Booking::selectRaw('YEAR(check_in) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::whereDate('check_in', Carbon::today())->count();
        $checkOutCount = Booking::whereDate('check_out', Carbon::today())->count();

        $rooms = Room::count();
        $roomtypes = RoomType::count();
        $galleries = Gallery::count();
        $customers = Customer::count();
        $users = User::count();
        $bookings = Booking::latest()->take(6)->get(); // Get the latest 6 bookings

        // Count distinct customers who made bookings in the last 7 days
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
            ->distinct('customer_id')
            ->count('customer_id');

        // Get check-in and check-out counts for the last 6 months
        $checkInCounts = [];
        $checkOutCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $checkInCounts[] = Booking::where('status', 'Checked-In')
                ->whereBetween('created_at', [$date->startOfMonth(), $date->endOfMonth()])
                ->count();
            $checkOutCounts[] = Booking::where('status', 'Checked-Out')
                ->whereBetween('created_at', [$date->startOfMonth(), $date->endOfMonth()])
                ->count();
        }

        // Get daily bookings data (count distinct customers per day)
        $dailyBookings = Booking::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT customer_id) as user_count'))
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        // Calculate today's check-ins and check-outs
        $today = Carbon::today();
        $checkInsToday = Booking::whereDate('actual_check_in', $today)->count();
        $checkOutsToday = Booking::whereDate('actual_check_out', $today)->count();

        // Total revenue for today
        $totalRevenue = Booking::whereDate('check_in', $today)
            ->sum('total_price');

        // Room statuses
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();
        $reservedRooms = Room::where('status', 'reserved')->count();

        // Define months in an array
        $months = collect([
            trans('menu.january'),
            trans('menu.february'),
            trans('menu.march'),
            trans('menu.april'),
            trans('menu.may'),
            trans('menu.june'),
            trans('menu.july'),
            trans('menu.august'),
            trans('menu.september'),
            trans('menu.october'),
            trans('menu.november'),
            trans('menu.december'),
        ]);

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->whereDate('created_at', today())
            ->count();

        return view('dashbord', [
            'users' => $users,
            'rooms' => $rooms,
            'galleries' => $galleries,
            'customers' => $customers,
            'roomtypes' => $roomtypes,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'recent_users_count' => $recent_users_count,
            'checkInCounts' => $checkInCounts,
            'checkOutCounts' => $checkOutCounts,
            'years' => $years,
            'dailyBookings' => $dailyBookings,
            'checkInsToday' => $checkInsToday,
            'checkOutsToday' => $checkOutsToday,
            'totalRevenue' => $totalRevenue,
            'availableRooms' => $availableRooms,
            'occupiedRooms' => $occupiedRooms,
            'maintenanceRooms' => $maintenanceRooms,
            'reservedRooms' => $reservedRooms,
            'months' => $months,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }


    /**
     * Automatically check out bookings after 12 PM if the check-out date has passed.
     */
    private function autoCheckOut()
    {
        $now = Carbon::now();

        // Only check-out bookings that are past the check-out date and the time is after 12 PM
        if ($now->hour >= 12) {
            $bookings = Booking::whereDate('check_out', '<', $now->toDateString())
                ->where('status', 'Checked-In')
                ->get();

            foreach ($bookings as $booking) {
                $booking->status = 'Checked-Out';
                $booking->actual_check_out = $now;
                $booking->save();
            }
        }
    }

    /**
     * Get reservation statistics for a specific year and month.
     */
    public function getReservationStatistics(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', null);

        // Query to get the booking count for each month
        $query = Booking::selectRaw('MONTH(check_in) as month, COUNT(*) as bookings')
            ->whereYear('check_in', $year);

        if ($month) {
            $query->whereMonth('check_in', $month);
        }

        $bookings = $query->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare data for months and booking counts
        $months = collect([
            trans('menu.january'),
            trans('menu.february'),
            trans('menu.march'),
            trans('menu.april'),
            trans('menu.may'),
            trans('menu.june'),
            trans('menu.july'),
            trans('menu.august'),
            trans('menu.september'),
            trans('menu.october'),
            trans('menu.november'),
            trans('menu.december'),
        ]);

        $bookingsData = array_fill(0, 12, 0);

        foreach ($bookings as $booking) {
            $monthIndex = $booking->month - 1;
            $bookingsData[$monthIndex] = $booking->bookings;
        }

        $maxBookings = max($bookingsData);
        $maxMonthIndex = array_search($maxBookings, $bookingsData);

        return response()->json([
            'months' => $months,
            'bookings' => $bookingsData,
            'maxMonthIndex' => $maxMonthIndex,
        ]);
    }

    /**
     * Get check-in and check-out data for a specific year and month.
     */
    public function getCheckInOutData(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');

        if ($month) {
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-$month-01")->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            $checkInCount = Booking::whereBetween('actual_check_in', [$startDate, $endDate])->count();
            $checkOutCount = Booking::whereBetween('actual_check_out', [$startDate, $endDate])->count();

            return response()->json([
                'month' => $month,
                'checkInCount' => $checkInCount,
                'checkOutCount' => $checkOutCount,
            ]);
        }

        $data = collect(range(1, 12))->map(function ($m) use ($year) {
            $startDate = Carbon::createFromFormat('Y-m-d', "$year-$m-01")->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            return [
                'month' => $m,
                'checkInCount' => Booking::whereBetween('actual_check_in', [$startDate, $endDate])->count(),
                'checkOutCount' => Booking::whereBetween('actual_check_out', [$startDate, $endDate])->count(),
            ];
        });

        return response()->json($data);
    }
}
