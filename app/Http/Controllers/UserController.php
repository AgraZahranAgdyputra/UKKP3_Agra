<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', [
            'users'=>User::latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create', [
            'roles' => role::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->pluck('name')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' =>['required', 'string', 'max:255'],
            'email' =>['required', 'email', 'max:255', 'unique:users,email'],
            'password' =>['required', 'confirmed', Password::min(8)],
            'role' => ['required', Rule::exists('roles', 'name')->where('guard_name', 'web')],
        ]);

        $role = $data['role'];
        unset($data['role']);

        $user = User::create($data);
        $user->assignRole($role);

        return redirect()->route('users.index')->with('status', 'oke data masuk boskyuhhh');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->pluck('name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' =>['required', 'string', 'max:255'],
            'email' =>['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id),],
            'password' =>['nullable', 'confirmed', Password::min(8)],
            'role' => ['required', Rule::exists('roles', 'name')->where('guard_name', 'web')],
        ]);

        if (blank($data['password'] ?? null)){
            unset($data['password']);
        }

        $role = $data['role'];
        unset($data['role']);

        $user->update($data);
        $user->syncRoles([$role]);

        return redirect()->route('users.index')->with('status', 'baru bro?');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->is($user)){
            return back()->withErrors([
                'user'=>'Sorry bet nih gabisa hapus akun yang lagi dipake',
            ]);
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'dah kehapus ye');
    }
}
