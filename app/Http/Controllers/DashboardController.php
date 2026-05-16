<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\ComplaintStatus;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan ringkasan statistik pengaduan untuk Kadis.
     */
    public function index(): View
    {
    // 1. Statistik Dasar
    $stats = [
        'total'    => Complaint::count(),
        'pending'  => Complaint::where('status', ComplaintStatus::PENDING)->count(),
        'process'  => Complaint::whereIn('status', [
                            ComplaintStatus::VERIFIED, 
                            ComplaintStatus::ASSIGNED, 
                            ComplaintStatus::IN_PROGRESS
                       ])->count(),
        'resolved' => Complaint::where('status', ComplaintStatus::RESOLVED)->count(),
    ];

    // 2. Aktivitas Terbaru
    $recentComplaints = Complaint::with(['user', 'category'])
        ->latest()
        ->take(5)
        ->get();

    // 3. Distribusi Kategori
    $categoryDistribution = DB::table('complaints')
        ->join('categories', 'complaints.category_id', '=', 'categories.id')
        ->select('categories.name', DB::raw('count(*) as total'))
        ->groupBy('categories.name')
        ->get();

    // 4. Data Grafik (Jika Anda menggunakan Chart.js nanti)
    $chartData = Complaint::select(
            DB::raw('COUNT(id) as count'), 
            DB::raw("DATE_FORMAT(created_at, '%M') as month"),
            DB::raw("DATE_FORMAT(created_at, '%Y%m') as month_sort")
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month', 'month_sort')
        ->orderBy('month_sort', 'asc')
        ->get();

    $categoryStats = DB::table('complaints')
    ->join('categories', 'complaints.category_id', '=', 'categories.id')
    ->select('categories.name', DB::raw('count(*) as total'))
    ->groupBy('categories.name')
    ->get();

    return view('kadis.dashboard', compact('stats', 'recentComplaints', 'categoryDistribution', 'chartData', 'categoryStats'));
    }

    public function complaints(): View
    {
        $complaints = Complaint::with(['user', 'category', 'assignedTo'])
            ->latest()
            ->paginate(15);

        return view('kadis.complaints.index', compact('complaints'));
    }

    public function showComplaint(Complaint $complaint): View
    {
        $complaint->load(['user', 'category', 'assignedTo', 'histories']);
        return view('kadis.complaints.show', compact('complaint'));
    }
}