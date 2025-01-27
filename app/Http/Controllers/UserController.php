<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Menggunakan Eloquent untuk mengambil data user
        $users = User::query()
            ->with('roles') // Memuat relasi roles
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->select('id', 'name', 'email', 'handphone', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as created_at'))
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Validate the request
        $validate = $request->validated([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'handphone' => 'required',
            'address' => 'required',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'handphone' => $request['handphone'],
            'address' => $request['address'],
        ]);

        $user->assignRole($request['role']); // Tetapkan role ke user

        return redirect(route('user.index'))->with('success', 'Data berhasil disimpan dan role telah ditetapkan');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('pages.users.edit', compact('user','roles'))->with('user', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'handphone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->update($request->only(['name', 'email', 'handphone', 'address']));

        // Sinkronisasi role
        $user->syncRoles($request->input('role'));

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Delete User Successfully');
    }
}


