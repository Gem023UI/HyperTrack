<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use DataTables;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        $stats = [
            'userCount' => User::count(),
            'productCount' => Product::count(),
            'orderCount' => Order::count(),
            'recentUsers' => User::latest()->take(5)->get()
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    /**
     * Display users datatable
     */
    public function usersIndex()
{
    $users = User::all(); // Fetch all users from the database
    return view('admin.user.index', compact('users'));
}


    /**
     * Return JSON data for users datatable
     */
    public function getUsersData()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);
        
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($user) {
                return '
                    <div class="btn-group">
                        <a href="'.route('admin.users.edit', $user->id).'" class="btn btn-sm btn-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="'.route('admin.users.destroy', $user->id).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm(\'Are you sure?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->editColumn('created_at', function($user) {
                return $user->created_at->format('M d, Y');
            })
            ->editColumn('updated_at', function($user) {
                return $user->updated_at->diffForHumans();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Update the role of a user
     */
    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }
    public function updateUserStatus(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->status = $request->status;
    $user->save();
    
    return back()->with('success', 'User status updated successfully');
}
}
