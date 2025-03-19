<?php

namespace App\Http\Controllers\Webfront;
use App\Http\Controllers\Controller;  // Correct import for base Controller

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Booking;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the clients.
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
        
        $clients = Client::all();
        return view('admin.clients.index', [
            'clients' => $clients,
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
     * Show the form for creating a new client.
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

        return view('admin.clients.create', [
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
     * Store a newly created client in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('clients', 'public');
            $validatedData['image'] = $path;
        }

        Client::create($validatedData);

        return redirect('clients')->with('status', 'Client created successfully.');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
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

        return view('admin.clients.show', [
            'client' => $client,
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
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
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

        return view('admin.clients.edit', [
            'client' => $client,
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
     * Update the specified client in the database.
     */
    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($client->image) {
                Storage::disk('public')->delete($client->image);
            }
            $path = $request->file('image')->store('clients', 'public');
            $validatedData['image'] = $path;
        }

        $client->update($validatedData);

        return redirect('clients')->with('status', 'Client updated successfully.');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy($clientId)
    {
        $client = Client::findOrFail($clientId);
        $client->delete();
        
        return redirect('/clients')->with('status', 'Client deleted successfully.');
    }
}
