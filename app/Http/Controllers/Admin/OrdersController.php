<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = $request->query('status');
        $movieId = $request->query('movie_id');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $orders = collect();
        $screenings = collect();
        $movies = collect();

        // Try to load real data only if models exist
        $OrderClass = '\\App\\Models\\Order';
        $ScreeningClass = '\\App\\Models\\Screening';
        $MovieClass = '\\App\\Models\\Movie';

        if (class_exists($OrderClass)) {
            $ordersQuery = $OrderClass::query()
                ->when($q !== '', function ($qb) use ($q) {
                    $qb->where(function ($sub) use ($q) {
                        $sub->where('code', 'like', "%$q%")
                            ->orWhere('customer_name', 'like', "%$q%")
                            ->orWhere('customer_email', 'like', "%$q%");
                    });
                })
                ->when($status, function ($qb) use ($status) { $qb->where('status', $status); })
                ->when($movieId, function ($qb) use ($movieId) { $qb->where('movie_id', $movieId); })
                ->when($dateFrom, function ($qb) use ($dateFrom) { $qb->whereDate('created_at', '>=', $dateFrom); })
                ->when($dateTo, function ($qb) use ($dateTo) { $qb->whereDate('created_at', '<=', $dateTo); })
                ->orderByDesc('created_at');

            $orders = $ordersQuery->paginate(12)->withQueryString();
        } else {
            $orders = new LengthAwarePaginator([], 0, 12);
        }

        if (class_exists($ScreeningClass)) {
            $screenings = $ScreeningClass::query()
                ->when($movieId, fn($qb)=>$qb->where('movie_id', $movieId))
                ->orderByDesc('screening_time')
                ->limit(50)
                ->get();
        }

        if (class_exists($MovieClass)) {
            $movies = $MovieClass::query()->orderBy('title')->limit(200)->get();
        }

        return view('admin.orders', compact('orders', 'screenings', 'movies', 'q', 'status', 'movieId', 'dateFrom', 'dateTo'));
    }
}
