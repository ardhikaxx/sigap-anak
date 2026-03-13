<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['nakesProfile', 'orangtuaProfile']);

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.manajemen.users', compact('users'));
    }

    public function create()
    {
        return view('admin.manajemen.users_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,dokter,bidan,ahli_gizi,kader,orangtua',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;
        $validated['email_verified'] = true;

        $user = User::create($validated);

        if (in_array($validated['role'], ['dokter', 'bidan', 'ahli_gizi', 'kader'])) {
            $user->nakesProfile()->create([
                'nip' => '19' . rand(100000, 999999) . rand(100, 999),
                'str_number' => 'STR/' . rand(100000, 999999),
                'spesialisasi' => $validated['role'] === 'bidan' ? 'Bidan' : ucfirst(str_replace('_', ' ', $validated['role'])),
                'verified_at' => now(),
            ]);
        } elseif ($validated['role'] === 'orangtua') {
            $user->orangtuaProfile()->create([
                'nik' => '32' . rand(100000, 999999) . rand(1000, 9999),
                'tanggal_lahir' => now()->subYears(rand(22, 45)),
                'jenis_kelamin' => 'P',
                'alamat' => 'Alamat belum diisi',
            ]);
        }

        return redirect()->route('admin.manajemen.users')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $user->load(['nakesProfile', 'orangtuaProfile']);
        return view('admin.manajemen.users_show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.manajemen.users_edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,dokter,bidan,ahli_gizi,kader,orangtua',
            'is_active' => 'boolean',
        ]);

        if ($request->password) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.manajemen.users')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.manajemen.users')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();
        return redirect()->route('admin.manajemen.users')->with('success', 'User berhasil dihapus');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status user diperbarui');
    }
}
