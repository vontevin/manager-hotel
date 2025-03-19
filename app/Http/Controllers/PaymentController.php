<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\RoomType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.customer', 'booking.room.roomType']);

        // Apply filters dynamically
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // Get statistics before pagination
        $totalPayments = $query->count();
        $totalRevenue = $query->sum('amount');

        $completedPayments = (clone $query)->where('status', 'completed')->count();
        $pendingPayments = (clone $query)->where('status', 'pending')->count();

        // Reset query builder for pagination
        $payments = $query->orderBy('payment_date', 'desc')->paginate(10);

        // Additional statistics
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

        return view('admin.payments.index', compact(
            'payments',
            'totalPayments',
            'totalRevenue',
            'completedPayments',
            'pendingPayments',
            'recent_users_count',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'websiteBookingCount'
        ));
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
        // Get all active bookings
        $bookings = Booking::with(['customer', 'room.roomType', 'payments'])
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->orderBy('check_in', 'desc')
            ->get()
            ->filter(function ($booking) {
                // Calculate total paid amount
                $paidAmount = $booking->payments->where('status', 'completed')->sum('amount');
                // Keep only bookings with remaining balance
                return $paidAmount < $booking->total_price;
            });

        return view('admin.payments.create', compact('bookings','websiteBookingCount', 'recent_users_count', 'booking_count', 'users', 'checkInCount', 'checkOutCount', 'bookings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'amount'         => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,paypal,other',
            'status'         => 'required|in:completed,pending,failed,refunded',
            'payment_date'   => 'required|date',
            'description'    => 'nullable|string',
            'card_last_four' => 'required_if:payment_method,credit_card|nullable|string|max:4',
            'transaction_id' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Generate Unique Receipt Number
            $receiptNumber = 'REC-' . strtoupper(Str::random(8));

            // Create Payment Record
            $payment = Payment::create([
                'booking_id'     => $validated['booking_id'],
                'amount'         => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'status'         => $validated['status'],
                'payment_date'   => $validated['payment_date'],
                'description'    => $validated['description'] ?? null,
                'receipt_number' => $receiptNumber,
                'transaction_id' => $validated['transaction_id'] ?? null,
                'card_last_four' => $validated['card_last_four'] ?? null,
            ]);

            // Update Booking Status if Payment is Completed
            if ($validated['status'] === 'completed') {
                $booking = Booking::findOrFail($validated['booking_id']);

                // Calculate Total Paid Amount
                $totalPaid = $booking->payments()->where('status', 'completed')->sum('amount');

                // Confirm Booking if Fully Paid
                if ($totalPaid >= $booking->total_price) {
                    $booking->update(['status' => 'confirmed']);
                }
            }

            DB::commit();

            return redirect()->route('payments.show', $payment->id)
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Payment Creation Failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to create payment. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['booking.customer', 'booking.room.roomType'])->findOrFail($id);

        // Get related payments for the same booking
        $relatedPayments = Payment::where('booking_id', $payment->booking_id)
            ->where('id', '!=', $payment->id)
            ->orderBy('payment_date', 'desc')
            ->limit(5)
            ->get();

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

        return view('admin.payments.show', compact(
            'payment',
            'relatedPayments',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'recent_users_count',
            'websiteBookingCount'
        ));
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


        $payment = Payment::with(['booking.customer', 'booking.room.roomType'])->findOrFail($id);
        return view('admin.payments.edit', compact('payment',
            'booking_count',
            'checkInCount',
            'checkOutCount',
            'bookings',
            'users',
            'recent_users_count',
            'websiteBookingCount'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'status' => 'required|in:completed,pending,failed,refunded',
            'payment_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Additional validations based on payment method
        if ($request->payment_method == 'credit_card') {
            $request->validate([
                'card_last_four' => 'nullable|string|max:4',
            ]);
        }

        // Start transaction
        DB::beginTransaction();

        try {
            // Store old values for booking update
            $oldStatus = $payment->status;

            // Update payment
            $payment->amount = $request->amount;
            $payment->payment_method = $request->payment_method;
            $payment->status = $request->status;
            $payment->payment_date = $request->payment_date;
            $payment->description = $request->description;
            $payment->transaction_id = $request->transaction_id;

            // Update payment method specific details
            if ($request->payment_method == 'credit_card') {
                $payment->card_last_four = $request->card_last_four;
                $payment->card_holder = $request->card_holder;
            }

            $payment->save();

            // Update booking status if payment status changed
            if ($oldStatus != $request->status || $oldStatus != 'completed' && $request->status == 'completed') {
                $booking = Booking::findOrFail($payment->booking_id);

                // Calculate total paid amount
                $totalPaid = $booking->payments()
                    ->where('status', 'completed')
                    ->sum('amount');

                // Update booking status based on payment
                if ($totalPaid >= $booking->total_price) {
                    $booking->status = 'confirmed';
                } else if ($booking->status == 'pending') {
                    // If there's some payment but not full, mark as confirmed
                    if ($totalPaid > 0) {
                        $booking->status = 'confirmed';
                    }
                }

                $booking->save();
            }

            DB::commit();

            return redirect()->route('payments.show', $payment->id)
                ->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating payment: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);

        // Start transaction
        DB::beginTransaction();

        try {
            // If payment was completed, update booking status
            if ($payment->status == 'completed') {
                $booking = Booking::findOrFail($payment->booking_id);

                // Delete the payment first to ensure it's not counted in the sum
                $payment->delete();

                // Calculate remaining paid amount
                $totalPaid = $booking->payments()
                    ->where('status', 'completed')
                    ->sum('amount');

                // Update booking status based on remaining payments
                if ($totalPaid == 0 && $booking->status == 'confirmed') {
                    $booking->status = 'pending';
                    $booking->save();
                }
            } else {
                // If not completed, just delete the payment
                $payment->delete();
            }

            DB::commit();

            return redirect()->route('payments.index')
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the payment receipt.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function receipt(string $id)
    {
        $payment = Payment::with(['booking.customer', 'booking.room.roomType'])->findOrFail($id);
        return view('admin.payments.receipt', compact('payment'));
    }

    /**
     * Add a payment to a booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $bookingId
     * @return \Illuminate\Http\Response
     */
    public function addPayment(Request $request, string $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Generate receipt number
        $receiptNumber = 'REC-' . strtoupper(Str::random(8));

        // Start transaction
        DB::beginTransaction();

        try {
            // Create payment
            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->amount = $request->amount;
            $payment->payment_method = $request->payment_method;
            $payment->status = 'completed';
            $payment->payment_date = now();
            $payment->description = $request->description;
            $payment->receipt_number = $receiptNumber;
            $payment->save();

            // Calculate total paid amount
            $totalPaid = $booking->payments()
                ->where('status', 'completed')
                ->sum('amount');

            // Update booking status based on payment
            if ($totalPaid >= $booking->total_price) {
                $booking->status = 'confirmed';
            } else if ($booking->status == 'pending') {
                // If there's some payment but not full, mark as confirmed
                $booking->status = 'confirmed';
            }

            $booking->save();

            DB::commit();

            return redirect()->route('bookings.show', $booking->id)
                ->with('success', 'Payment added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error adding payment: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Export payments to CSV or PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $format = $request->format ?? 'csv';

        $query = Payment::with(['booking.customer', 'booking.room.roomType']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $payments = $query->orderBy('payment_date', 'desc')->get();

        if ($format == 'pdf') {
            $pdf = PDF::loadView('payments.export_pdf', compact('payments'));
            return $pdf->download('payments_' . date('Y-m-d') . '.pdf');
        } else {
            // CSV export
            $filename = 'payments_' . date('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($payments) {
                $file = fopen('php://output', 'w');

                // Add headers
                fputcsv($file, [
                    'Receipt #',
                    'Booking #',
                    'Guest',
                    'Room',
                    'Amount',
                    'Method',
                    'Status',
                    'Date',
                    'Transaction ID',
                    'description'
                ]);

                // Add data
                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->receipt_number,
                        $payment->booking->booking_number,
                        $payment->booking->guest->full_name,
                        $payment->booking->room->room_number . ' (' . $payment->booking->room->roomType->name . ')',
                        $payment->amount,
                        ucfirst(str_replace('_', ' ', $payment->payment_method)),
                        ucfirst($payment->status),
                        $payment->payment_date->format('Y-m-d H:i'),
                        $payment->transaction_id ?? 'N/A',
                        $payment->description ?? 'N/A'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }

    public function showRoom($id)
    {
        // Find the room type by ID
        $roomType = RoomType::with('rooms', 'amenities')->find($id);

        if (!$roomType) {
            return redirect()->back()->with('error', 'Room Type not found.');
        }

        // Get all room types for the carousel
        $roomTypes = RoomType::all();

        return view('web_frontend.frontwebs.viewroom', compact('roomType', 'roomTypes'));
    }
}
