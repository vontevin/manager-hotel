<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view user',['only'=>['index']]);
        $this->middleware('permission:create user',['only'=>['create','store']]);
        $this->middleware('permission:update user',['only'=>['update','edit']]);
        $this->middleware('permission:delete user',['only'=>['destroy']]);
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
        
        $users = User::get();
        return view('role-permission.user.index',[
            'users' => $users,
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

        $roles = Role::pluck('name','name')->all();
        return view('role-permission.user.create',[
            'roles' => $roles,'customers' => $customers,
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required',
        ]);

        $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
        
        $user->syncRoles($request->roles);
        return redirect('/users')->with('status','User Created Successfully With Roles');
    }

    public function edit(User $user)
    {
        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();  
        $checkOutCount = Booking::where('status', 'check_out')->count();  
        $bookings = Booking::latest()->take(5)->get(); 
        $users = User::count();

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id') 
        ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $customers = Customer::get();

        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('role-permission.user.edit',[
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
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

    public function update(Request $request, User $user) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if (!empty($request->password)){
            $data +=[
                'password' => Hash::make($request->password),
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status','User Updated Successfully With Roles');
    }

    public function showChangePasswordForm($id)
    {
        $booking_count = Booking::count(); // Count of bookings
        $checkInCount = Booking::where('status', 'check_in')->count();  
        $checkOutCount = Booking::where('status', 'check_out')->count();  
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id') 
        ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $customers = Customer::get();

        if (Auth::id() != $id) {
            abort(403, 'Unauthorized action.');
        }

        return view('role-permission.change-password.change_password',[
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

    public function changePassword(Request $request, $id)
    {

        if (Auth::id() != $id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();


        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Update the password
        // $user->password = Hash::make($request->new_password);
        // $user->save();

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('status', 'Password changed successfully.🤞😉');
    }

    public function profile()
    {
        $booking_count = Booking::count();
        $checkInCount = Booking::where('status', 'check_in')->count();  
        $checkOutCount = Booking::where('status', 'check_out')->count();  
        $bookings = Booking::latest()->take(5)->get();
        $users = User::count();

        $recent_users_count = Booking::where('created_at', '>=', now()->subDays(7))
        ->distinct('customer_id')
        ->count('customer_id');

        $websiteBookingCount = Booking::where('booking_source', 'Website')
            ->where('status', 'Pending')
            ->whereDate('created_at', today())
            ->count();

        $customers = Customer::get();

        return view('role-permission.profile.index',[
            'customers' => $customers,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings, // Pass booking records
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'user' => Auth::user(),
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);
    
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user = User::find(Auth::id());
        $user->save();
    
        return redirect()->route('profile')->with('status', 'Profile updated successfully.');
    }



    public function destroy($userId)
    {
        $user = User::findOrfail($userId);
        $user->delete();
        
        return redirect('/users')->with('status','User Deleted Successfully');
    }
}

