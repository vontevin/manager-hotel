<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class CheckInOutController extends Controller
{
    /**
     * Display a listing of check-ins and check-outs.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'room', 'room.roomType']);

        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();

            $query->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in', [$startDate, $endDate])
                  ->orWhereBetween('check_out', [$startDate, $endDate]);
            });
        } else {
            // Default to current week
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();

            $query->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in', [$startDate, $endDate])
                  ->orWhereBetween('check_out', [$startDate, $endDate]);
            });
        }

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('check_in')->paginate(15);

        // Get counts for today
        $today = Carbon::today();
        $checkInsToday = Booking::whereDate('check_in', $today)->count();
        $checkOutsToday = Booking::whereDate('check_out', $today)->count();

        return view('admin.check_in_out.index', compact('bookings', 'checkInsToday', 'checkOutsToday', 'startDate', 'endDate'));
    }

    /**
     * Display check-ins and check-outs for today.
     */
    public function today()
    {
        $today = Carbon::today();

        // Get today's check-ins
        $checkIns = Booking::with(['customer', 'room', 'room.roomType'])
            ->whereDate('check_in', $today)
            ->orderBy('check_in')
            ->get();

        // Get today's check-outs
        $checkOuts = Booking::with(['customer', 'room', 'room.roomType'])
            ->whereDate('check_out', $today)
            ->orderBy('check_out')
            ->get();

        // Get counts
        $pendingCheckIns = $checkIns->where('status', 'confirmed')->count();
        $completedCheckIns = $checkIns->where('status', 'checked_in')->count();
        $pendingCheckOuts = $checkOuts->where('status', 'checked_in')->count();
        $completedCheckOuts = $checkOuts->where('status', 'checked_out')->count();

        $checkInsToday = Booking::whereDate('check_in', $today)->count();
        $checkOutsToday = Booking::whereDate('check_out', $today)->count();

        return view('admin.check_in_out.today', compact(
            'checkIns',
            'checkOuts',
            'today',
            'pendingCheckIns',
            'completedCheckIns',
            'pendingCheckOuts',
            'completedCheckOuts',
            'checkInsToday',
            'checkOutsToday'
        ));
    }
}
