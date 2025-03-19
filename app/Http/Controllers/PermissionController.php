<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view permission',['only'=>['index']]);
        $this->middleware('permission:create permission',['only'=>['create','store']]);
        $this->middleware('permission:update permission',['only'=>['update','edit']]);
        $this->middleware('permission:delete permission',['only'=>['destroy']]);
    }

    public function index()
    {
        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();  
        $checkOutCount = Booking::where('status', 'check_out')->count();  
        $bookings = Booking::latest()->take(5)->get(); 
        $users = User::count();

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id') // Use customer_id or any unique field representing a user
        ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $customers = Customer::get();

        $permissions = Permission::get();
        return view('role-permission.permission.index',[
            'permissions' => $permissions,
            'customers' => $customers,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }

    
    public function create()
    {
        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();  
        $checkOutCount = Booking::where('status', 'check_out')->count();  
        $bookings = Booking::latest()->take(5)->get(); 
        $users = User::count();

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id') // Use customer_id or any unique field representing a user
        ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $customers = Customer::get();
        
        return view('role-permission.permission.create',[
            'customers' => $customers,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings, // Pass booking records
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name',
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission Created Successfully');
    }
    public function edit(Permission $permission)
    {
        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();  
        $checkOutCount = Booking::where('status', 'check_out')->count();  
        $bookings = Booking::latest()->take(5)->get(); 
        $users = User::count();

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id') // Use customer_id or any unique field representing a user
        ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $customers = Customer::get();

        return view('role-permission.permission.edit',[
            'permission' => $permission,
            'customers' => $customers,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings, // Pass booking records
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission Updated Successfully');
    }
    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();

        return redirect('permissions')->with('status', 'Permission Delete Successfully');
    }
}
