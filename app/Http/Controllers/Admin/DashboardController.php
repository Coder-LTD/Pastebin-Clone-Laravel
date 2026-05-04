<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function loginForm(): View
    {
        return view('admin.login');
    }

    /**
     * Authenticate with the admin password.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $adminPassword = config('app.admin_password', 'admin123');

        if ($request->input('password') !== $adminPassword) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Invalid admin password.');
        }

        session(['admin_authenticated' => true]);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Log out of the admin area.
     */
    public function logout(): RedirectResponse
    {
        session()->forget('admin_authenticated');

        return redirect()->route('admin.login')
            ->with('success', 'Logged out successfully.');
    }

    /**
     * Show the admin dashboard with paste listings and filters.
     */
    public function index(Request $request): View
    {
        $query = Paste::query()->latest();

        // Filter by visibility
        $visibility = $request->input('visibility', 'all');
        if ($visibility !== 'all') {
            $query->where('visibility', $visibility);
        }

        // Filter by expiry status
        $status = $request->input('status', 'all');
        if ($status === 'active') {
            $query->where('is_burned', false)
                ->where(function ($q) {
                    $q->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                });
        } elseif ($status === 'expired') {
            $query->where('is_burned', false)
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', now());
        } elseif ($status === 'burned') {
            $query->where('is_burned', true);
        }

        // Filter by search
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $pastes = $query->paginate(50)->withQueryString();

        // Stats
        $stats = [
            'total' => Paste::count(),
            'public' => Paste::where('visibility', 'public')->count(),
            'private' => Paste::where('visibility', 'private')->count(),
            'unlisted' => Paste::where('visibility', 'unlisted')->count(),
        ];

        return view('admin.dashboard', compact('pastes', 'stats', 'visibility', 'status', 'search'));
    }

    /**
     * Delete a specific paste by slug.
     */
    public function destroy(string $slug): RedirectResponse
    {
        $paste = Paste::where('slug', $slug)->firstOrFail();
        $paste->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', "Paste \"{$slug}\" deleted.");
    }

    /**
     * Bulk-delete all expired and burned pastes.
     */
    public function destroyExpired(): RedirectResponse
    {
        $expiredQuery = Paste::where('is_burned', true)
            ->orWhere(function ($q) {
                $q->where('is_burned', false)
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '<=', now());
            });

        $count = $expiredQuery->count();
        $expiredQuery->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', "{$count} expired/burned paste(s) deleted.");
    }
}
