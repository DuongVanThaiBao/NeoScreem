<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MarketingController extends Controller
{
    public function campaigns(Request $request)
    {
        return view('admin.marketing.campaigns');
    }

    public function analytics(Request $request)
    {
        $range = $request->get('range', 'last_30');
        $start = null; $end = now()->toDateString();

        switch ($range) {
            case 'today':
                $start = now()->toDateString();
                break;
            case 'last_7':
                $start = now()->subDays(6)->toDateString();
                break;
            case 'last_30':
            default:
                $start = now()->subDays(29)->toDateString();
                break;
            case 'custom':
                $start = $request->get('start_date');
                $end = $request->get('end_date');
                break;
        }

        $query = \App\Models\Statistics::query()
            ->whereBetween('date', [$start, $end])
            ->orderBy('date');

        $rows = $query->get();

        $totals = [
            'revenue' => (float) $rows->sum('revenue_today'),
            'tickets' => (int) $rows->sum('tickets_sold_today'),
            'clicks' => 0,
            'interactions' => 0,
            'avg_roi' => $rows->avg('campaign_roi') ?? 0,
        ];

        $labels = [];
        $series = [
            'revenue' => [],
            'clicks' => [],
            'conversions' => [],
        ];

        foreach ($rows as $r) {
            $labels[] = optional($r->date)->format('d/m');
            $mc = (array) ($r->marketing_campaign_stats ?? []);
            $clicks = (int) ($mc['clicks'] ?? 0);
            $interactions = (int) ($mc['interactions'] ?? 0);
            $series['revenue'][] = (float) $r->revenue_today;
            $series['clicks'][] = $clicks;
            $series['conversions'][] = $interactions;
            $totals['clicks'] += $clicks;
            $totals['interactions'] += $interactions;
        }

        $derived = [
            'engagement_rate' => $totals['clicks'] > 0 ? round(($totals['interactions'] / $totals['clicks']) * 100, 2) : 0,
            // CPA and Spend cannot be computed without real spend data; omitted intentionally
        ];

        return view('admin.marketing.analytics', [
            'range' => $range,
            'start' => $start,
            'end' => $end,
            'totals' => $totals,
            'labels' => $labels,
            'series' => $series,
            'derived' => $derived,
        ]);
    }

    public function targets(Request $request)
    {
        $data = [
            'ageLabels' => [], 'ageData' => [],
            'genderLabels' => [], 'genderData' => [],
            'genreLabels' => [], 'genreData' => [],
            'timeLabels' => [], 'timeData' => [],
            'channelLabels' => [], 'channelData' => [],
            'spendLabels' => ['VIP (≥5 vé/30 ngày)','Thường xuyên (2-4/30 ngày)','Mới (1/30 ngày)'], 'spendData' => [0,0,0],
        ];

        // Demographics from Users
        if (class_exists('App\\Models\\User')) {
            $User = app('App\\Models\\User');
            // Avoid selecting columns that may not exist yet
            $users = $User::query()->get();

            // Age buckets
            $buckets = [
                '13-17' => 0,
                '18-24' => 0,
                '25-34' => 0,
                '35-44' => 0,
                '45+' => 0,
            ];
            foreach ($users as $u) {
                if (!$u->dob) continue;
                $age = \Carbon\Carbon::parse($u->dob)->age;
                if ($age >= 13 && $age <= 17) $buckets['13-17']++;
                elseif ($age >= 18 && $age <= 24) $buckets['18-24']++;
                elseif ($age >= 25 && $age <= 34) $buckets['25-34']++;
                elseif ($age >= 35 && $age <= 44) $buckets['35-44']++;
                elseif ($age >= 45) $buckets['45+']++;
            }
            $data['ageLabels'] = array_keys($buckets);
            $data['ageData'] = array_values($buckets);

            // Gender
            $genderCounts = Schema::hasColumn('users','gender')
                ? $users->groupBy('gender')->map->count()->filter()
                : collect();
            $data['genderLabels'] = $genderCounts->keys()->values();
            $data['genderData'] = $genderCounts->values();
        }

        // Behavior from Orders and Movies
        $OrderClass = 'App\\Models\\Order';
        $MovieClass = 'App\\Models\\Movie';
        if (class_exists($OrderClass)) {
            $since30 = now()->subDays(30);
            $orders = $OrderClass::query()->with(['movie' => function($q){ $q->select('id','genre'); }])
                ->whereNotNull('created_at')
                ->get(['id','user_id','movie_id','total_amount','channel','created_at']);

            // Time preferences by hour (0-23)
            $timeBuckets = array_fill(0, 24, 0);
            foreach ($orders as $o) {
                $h = (int) \Carbon\Carbon::parse($o->created_at)->format('G');
                $timeBuckets[$h]++;
            }
            $data['timeLabels'] = range(0,23);
            $data['timeData'] = array_values($timeBuckets);

            // Channel distribution
            $channelCounts = $orders->groupBy('channel')->map->count()->filter();
            $data['channelLabels'] = $channelCounts->keys()->values();
            $data['channelData'] = $channelCounts->values();

            // Genre preferences (by orders)
            if (class_exists($MovieClass)) {
                $genreCounts = [];
                foreach ($orders as $o) {
                    $genre = optional($o->movie)->genre;
                    if (!$genre) continue;
                    $genreCounts[$genre] = ($genreCounts[$genre] ?? 0) + 1;
                }
                arsort($genreCounts);
                $data['genreLabels'] = array_keys($genreCounts);
                $data['genreData'] = array_values($genreCounts);
            }

            // Spend tiers in last 30 days by ticket count
            $perUserCount = $OrderClass::query()
                ->where('created_at','>=',$since30)
                ->selectRaw('user_id, COUNT(*) as c')
                ->whereNotNull('user_id')
                ->groupBy('user_id')
                ->pluck('c','user_id');
            $vip=0;$freq=0;$new=0;
            foreach ($perUserCount as $uid=>$c) {
                if ($c >= 5) $vip++; elseif ($c >= 2) $freq++; else $new++;
            }
            $data['spendData'] = [$vip,$freq,$new];
        }

        return view('admin.marketing.targets', $data);
    }

    public function storeSegment(Request $request)
    {
        $filters = [
            'age_range' => $request->input('age_range'),
            'gender' => $request->input('gender'),
            'channel' => $request->input('channel'),
            'spend_tier' => $request->input('spend_tier'),
        ];

        $name = $request->input('name', 'Segment '.now()->format('Y-m-d H:i'));

        // Build base query for users
        if (!class_exists('App\\Models\\User')) {
            return back()->with('error','Users model not found');
        }
        $User = app('App\\Models\\User');
        $query = $User::query();

        // Age filter
        if (!empty($filters['age_range']) && Schema::hasColumn('users','dob')) {
            [$min,$max] = $this->parseAgeRange($filters['age_range']);
            $query->whereNotNull('dob');
            // Filter via DOB boundaries
            $dobMax = now()->subYears($min)->toDateString();
            $dobMin = $max ? now()->subYears($max+1)->addDay()->toDateString() : null;
            $query->whereDate('dob','<=',$dobMax);
            if ($dobMin) $query->whereDate('dob','>=',$dobMin);
        }

        // Gender filter
        if (!empty($filters['gender']) && Schema::hasColumn('users','gender')) {
            $query->where('gender', $filters['gender']);
        }

        // Channel and spend tier require orders
        $ids = $query->pluck('id');
        if (class_exists('App\\Models\\Order') && (!empty($filters['channel']) || !empty($filters['spend_tier']))) {
            $Order = app('App\\Models\\Order');
            $since30 = now()->subDays(30);
            $ordersQ = $Order::query()->whereIn('user_id',$ids);
            if (!empty($filters['channel'])) {
                $ordersQ->where('channel',$filters['channel']);
            }
            $perUser = $ordersQ->where('created_at','>=',$since30)
                ->selectRaw('user_id, COUNT(*) as c, SUM(COALESCE(total_amount,0)) as s')
                ->groupBy('user_id')
                ->get();
            $map = $perUser->keyBy('user_id');

            $filtered = $ids->filter(function($uid) use ($map, $filters){
                if (empty($filters['spend_tier'])) return true;
                $c = (int) optional($map->get($uid))->c;
                if ($filters['spend_tier']==='vip') return $c>=5;
                if ($filters['spend_tier']==='frequent') return $c>=2 && $c<=4;
                if ($filters['spend_tier']==='new') return $c===1;
                return true;
            });
            $size = $filtered->count();
        } else {
            $size = $ids->count();
        }

        $SegmentClass = 'App\\Models\\Segment';
        if (class_exists($SegmentClass)) {
            $seg = $SegmentClass::create([
                'name' => $name,
                'filters' => $filters,
                'size' => $size,
                'created_by' => optional($request->user())->id,
            ]);
        }

        return back()->with('success','Đã lưu segment: '.$name.' ('.$size.' khách hàng)');
    }

    public function exportSegment(Request $request)
    {
        if (!class_exists('App\\Models\\User')) {
            abort(400,'Users model not found');
        }
        $User = app('App\\Models\\User');
        $OrderClass = class_exists('App\\Models\\Order') ? app('App\\Models\\Order') : null;

        // Same filters as storeSegment
        $filters = [
            'age_range' => $request->input('age_range'),
            'gender' => $request->input('gender'),
            'channel' => $request->input('channel'),
            'spend_tier' => $request->input('spend_tier'),
        ];

        $select = ['id','name','email','created_at'];
        if (Schema::hasColumn('users','gender')) { $select[] = 'gender'; }
        if (Schema::hasColumn('users','dob')) { $select[] = 'dob'; }
        $q = $User::query()->select($select);
        if (!empty($filters['age_range']) && Schema::hasColumn('users','dob')) {
            [$min,$max] = $this->parseAgeRange($filters['age_range']);
            $dobMax = now()->subYears($min)->toDateString();
            $dobMin = $max ? now()->subYears($max+1)->addDay()->toDateString() : null;
            $q->whereNotNull('dob')->whereDate('dob','<=',$dobMax);
            if ($dobMin) $q->whereDate('dob','>=',$dobMin);
        }
        if (!empty($filters['gender']) && Schema::hasColumn('users','gender')) { $q->where('gender',$filters['gender']); }

        $users = $q->get();
        $ids = $users->pluck('id');

        $perUserAgg = collect();
        if ($OrderClass) {
            $since30 = now()->subDays(30);
            $perUserAgg = $OrderClass::query()
                ->whereIn('user_id',$ids)
                ->when(!empty($filters['channel']), fn($qb)=>$qb->where('channel',$filters['channel']))
                ->selectRaw('user_id, COUNT(*) as total_orders, SUM(COALESCE(total_amount,0)) as total_spend, MAX(created_at) as last_order')
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="targets_export_'.now()->format('Ymd_His').'.csv"',
        ];

        $callback = function() use ($users, $perUserAgg) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['name','email','gender','age','total_orders','total_spend','last_order']);
            foreach ($users as $u) {
                $age = (\Illuminate\Support\Facades\Schema::hasColumn('users','dob') && $u->dob) ? \Carbon\Carbon::parse($u->dob)->age : null;
                $agg = $perUserAgg->get($u->id);
                fputcsv($out, [
                    $u->name,
                    $u->email,
                    (\Illuminate\Support\Facades\Schema::hasColumn('users','gender') ? $u->gender : null),
                    $age,
                    (int) optional($agg)->total_orders,
                    (float) optional($agg)->total_spend,
                    optional(optional($agg)->last_order)->toDateTimeString(),
                ]);
            }
            fclose($out);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    private function parseAgeRange(?string $range): array
    {
        switch ($range) {
            case '13-17': return [13,17];
            case '18-24': return [18,24];
            case '25-34': return [25,34];
            case '35-44': return [35,44];
            case '45+': return [45,null];
            default: return [null,null];
        }
    }
}
