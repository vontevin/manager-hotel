<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    // Display all customers
    public function index(Request $request)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id')
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
        
        $query = \App\Models\Customer::query();
        
        // Filter by name if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->orderBy('last_name')->get();
        
        return view('admin.customers.index', compact('customers','websiteBookingCount', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id')
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

        if ($request->has('from_booking')) {
            session(['from_booking' => true]);
        }

        return view('admin.customers.create',[
            'recent_users_count' => $recent_users_count,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'users' => $users,
            'websiteBookingCount' => $websiteBookingCount,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'identification_type' => 'nullable|string|max:50',
            'identification_number' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        $customer = new Customer();
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $validated['last_name'];
        $customer->email = $validated['email'] ?? null;
        $customer->phone = $validated['phone'] ?? null;
        $customer->address = $validated['address'] ?? null;
        $customer->city = $validated['city'] ?? null;
        $customer->state = $validated['state'] ?? null;
        $customer->country = $validated['country'] ?? null;
        $customer->postal_code = $validated['postal_code'] ?? null;
        $customer->date_of_birth = $validated['date_of_birth'] ?? null;
        $customer->identification_type = $validated['identification_type'] ?? null;
        $customer->identification_number = $validated['identification_number'] ?? null;
        $customer->description = $validated['description'] ?? null;
        $customer->gender = $validated['gender'] ?? null;
        
        $customer->save();

        if (session('from_booking')) {
            session()->forget('from_booking');
            return redirect()->route('bookings.create', ['customer_id' => $customer->id])
                ->with('status', 'Customer created successfully! You can now proceed with booking.');
        }

        // Return a response, you can redirect or send a success message
        return redirect()->route('customers.index')->with('status', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id')
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

        $customer = \App\Models\Customer::with('bookings.room.roomType')->findOrFail($id);
        
        return view('admin.customers.show', compact('customer','websiteBookingCount', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
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

        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();
        $checkOutCount = Booking::where('status', 'check_out')->count();
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $customer = \App\Models\Customer::findOrFail($id);
        
        return view('admin.customers.edit', compact('customer','websiteBookingCount', 'recent_users_count', 'booking_count', 'checkInCount', 'checkOutCount', 'bookings', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the customer by ID
        $customer = Customer::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'identification_type' => 'nullable|string|max:50',
            'identification_number' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        // Update the customer with the validated data
        $customer->first_name = $validated['first_name'];
        $customer->last_name = $validated['last_name'];
        $customer->email = $validated['email'];
        $customer->phone = $validated['phone'];
        $customer->address = $validated['address'] ?? null;
        $customer->city = $validated['city'] ?? null;
        $customer->state = $validated['state'] ?? null;
        $customer->country = $validated['country'] ?? null;
        $customer->postal_code = $validated['postal_code'] ?? null;
        $customer->date_of_birth = $validated['date_of_birth'] ?? null;
        $customer->identification_type = $validated['identification_type'] ?? null;
        $customer->identification_number = $validated['identification_number'] ?? null;
        $customer->description = $validated['description'] ?? null;
        $customer->gender = $validated['gender'] ?? null;

        // Save the updated customer
        $customer->save();

        // Return a response, you can redirect or send a success message
        return redirect()->route('customers.index')->with('status', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        
        // Check if guest has bookings
        if ($customer->bookings()->count() > 0) {
            return redirect()->route('customers.show', $customer)
                ->with('error', 'Cannot delete guest with existing bookings.');
        }
        
        $customer->delete();
        
        return redirect()->route('customers.index')
            ->with('status', 'Customer deleted successfully.');
    }
}
