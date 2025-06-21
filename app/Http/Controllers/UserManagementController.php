<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;


class UserManagementController extends Controller
{
    /**
     * Display a listing of users with filtering and search
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('nrp', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('satuan_kerja', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by satuan kerja
        if ($request->filled('satuan_kerja')) {
            $query->where('satuan_kerja', 'LIKE', "%{$request->satuan_kerja}%");
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = ['name', 'email', 'role', 'satuan_kerja', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $users = $query->paginate(15)->appends($request->all());

        // Statistics
        $stats = [
            'total_users' => User::count(),
            'total_operators' => User::where('role', 'operator')->count(),
            'total_admins' => User::where('role', 'admin_bnn')->count(),
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // Get unique satuan kerja for filter dropdown
        $satuanKerjaOptions = User::select('satuan_kerja')
            ->distinct()
            ->whereNotNull('satuan_kerja')
            ->pluck('satuan_kerja');

        if ($request->ajax()) {
            $html = view('admin.users.partials.user-table', compact('users'))->render();
            return response()->json([
                'html' => $html,
                'pagination' => $users->links('pagination::tailwind')->render(),
                'stats' => $stats
            ]);
        }

        return view('admin.user-management', compact('users', 'stats', 'satuanKerjaOptions'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = [
            'operator' => 'Tim Penyidik (Operator)',
            'admin_bnn' => 'Admin Tim Assessment Terpadu'
        ];

        return view('admin.create-user', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nrp' => 'required|string|max:20|unique:users',
            'no_telp' => 'required|string|max:15',
            'satuan_kerja' => 'required|string|max:255',
            'role' => 'required|in:operator,admin_bnn',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nrp' => $validated['nrp'],
                'no_telp' => $validated['no_telp'],
                'satuan_kerja' => $validated['satuan_kerja'],
                'role' => $validated['role'],
            ];

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', $filename, 'public');
                $userData['profile_photo'] = $path;
            }

            $user = User::create($userData);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil dibuat!',
                    'user' => $user
                ]);
            }

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Akun berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        // Additional data for user profile
        $userStats = [
            'total_reports' => 0, // Implement based on your laporan model
            'pending_reports' => 0,
            'approved_reports' => 0,
            'rejected_reports' => 0,
        ];

        // If you have LaporanTAT model relationship
        if (class_exists('App\Models\LaporanTAT')) {
            $userStats = [
                'total_reports' => $user->laporanTAT()->count(),
                'pending_reports' => $user->laporanTAT()->where('status', 'menunggu')->count(),
                'approved_reports' => $user->laporanTAT()->where('status', 'diterima')->count(),
                'rejected_reports' => $user->laporanTAT()->where('status', 'ditolak')->count(),
            ];
        }

        return view('admin.user-show', compact('user', 'userStats'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $roles = [
            'operator' => 'Tim Penyidik (Operator)',
            'admin_bnn' => 'Admin Tim Assessment Terpadu'
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => 'nullable|string|min:8|confirmed',
            'nrp' => ['required', 'string', 'max:20',],
            'no_telp' => 'required|string|max:15',
            'satuan_kerja' => 'required|string|max:255',
            'role' => 'required|in:operator,admin_bnn',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'nrp' => $validated['nrp'],
                'no_telp' => $validated['no_telp'],
                'satuan_kerja' => $validated['satuan_kerja'],
                'role' => $validated['role'],
            ];

            // Update password only if provided
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo
                $user->deleteOldPhoto();

                $file = $request->file('profile_photo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', $filename, 'public');
                $userData['profile_photo'] = $path;
            }

            $user->update($userData);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil diperbarui!',
                    'user' => $user->fresh()
                ]);
            }

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Akun berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        try {
            // Cek apakah user mencoba menghapus akun sendiri
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun sendiri!'
                ], 400);
            }

            DB::beginTransaction();

            // Hapus foto profil jika ada
            if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // Atau jika ada method deleteOldPhoto
            if (method_exists($user, 'deleteOldPhoto')) {
                $user->deleteOldPhoto();
            }

            // Log untuk debugging (opsional, hapus dd())
            Log::info('Menghapus user: ' . $user->name . ' (ID: ' . $user->id . ')');

            // Pilih salah satu metode delete:

            // Jika menggunakan SoftDeletes (soft delete)
            $user->delete();

            // Jika ingin hapus permanen atau tidak pakai SoftDeletes
            // $user->forceDelete();

            DB::commit();

            Log::info('User berhasil dihapus: ' . $user->name);

            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus akun.'
            ], 500);
        }
    }


    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(User $user)
    {
        try {
            // Add 'is_active' column to users table if not exists
            $user->update([
                'is_active' => !($user->is_active ?? true)
            ]);

            $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => "Akun berhasil {$status}!",
                'is_active' => $user->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user)
    {
        try {
            $newPassword = 'password123'; // Or generate random password

            $user->update([
                'password' => Hash::make($newPassword)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil direset!',
                'new_password' => $newPassword
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export users data
     */
    public function export(Request $request)
    {
        $query = User::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('nrp', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get();

        // Simple CSV export
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'ID',
                'Nama',
                'Email',
                'NRP',
                'No. Telepon',
                'Satuan Kerja',
                'Role',
                'Tanggal Dibuat'
            ]);

            // CSV Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->nrp,
                    $user->no_telp,
                    $user->satuan_kerja,
                    $user->role,
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
