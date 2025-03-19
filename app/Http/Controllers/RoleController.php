<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view role',['only'=>['index']]);
        $this->middleware('permission:create role',['only'=>['create','store','addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:update role',['only'=>['update','edit']]);
        $this->middleware('permission:delete role',['only'=>['destroy']]);
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
        
        $roles = Role::get();
        return view('role-permission.role.index',[
            'roles' => $roles,
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

        return view('role-permission.role.create',[
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
                'unique:roles,name',
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Roles Created Successfully');
    }
    public function edit(Role $role)
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

        return view('role-permission.role.edit',[
            'role' => $role,
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
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,'.$role->id
            ]
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Roles Updated Successfully');
    }
    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();

        return redirect('roles')->with('status', 'Roles Delete Successfully');
    }

    protected $permissionGroups = [
        
        'Role' => [
            'create role', 'view role', 'edit role', 'delete role', 'update role'
        ],
        'Permission' => [
            'create permission','role permission', 'view permission', 'edit permission', 'delete permission', 'update permission'
        ],
        'User' => [
            'create user', 'view user', 'edit user', 'delete user', 'update user'
        ],
        'Room' => [
            'Create Room', 'View Room', 'Edit Room', 'Delete Room'
        ],
        'Room Type' => [
            'Create Roomtype', 'View Roomtype', 'Edit Roomtype', 'Delete Roomtype'
        ],
        'Customer' => [
            'View Customer', 'Edit Customer', 'Delete Customer', 'Create Customer',
        ],
        'Booking' => [
            'View Booking', 'Edit Booking', 'Delete Booking', 'check-in bookings', 'check-out bookings', 'Create Booking'
        ],
        'Gallery' => [
            'View Gallery', 'Edit Gallery', 'Delete Gallery', 'Create Gallery'
        ],
        'Package' => [
            'View Package', 'Edit Package', 'Delete Package', 'Create Package'
        ],
        'Client' => [
            'View Client', 'Edit Client', 'Delete Client', 'Create Client'
        ],
        'Payment' => [
            'View Payment', 'Edit Payment', 'Delete Payment', 'Generate Receipt', 'Create Payment'
        ],
        'Amenity' => [
            'Edit Amenity', 'Delete Amenity', 'View Amenity', 'Create Amenity'
        ],
        'Staff' => [
            'View Staff', 'Edit Staff', 'Delete Staff', 'Create Staff'
        ]
        
    ];

    public function addPermissionToRole($roleId)
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

        $allPermissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                ->where('role_has_permissions.role_id', $role->id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();
        
        return view('role-permission.role.permissions',[
            'role' => $role,  
            'allPermissions' => $allPermissions,
            'rolePermissions' => $rolePermissions,
            'customers' => $customers,
            'booking_count' => $booking_count,
            'checkInCount' => $checkInCount,
            'checkOutCount' => $checkOutCount,
            'bookings' => $bookings,
            'users' => $users,
            'recent_users_count' => $recent_users_count,
            'permissionGroups' => $this->permissionGroups,
            'websiteBookingCount' => $websiteBookingCount
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role ->syncPermissions($request->permission);

        return redirect('roles')->with('status', 'Permission added to role Successfully');
    }
}
