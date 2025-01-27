<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::latest();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

                        $query->whereBetween('created_at', [$startDate, $endDate]);

        } elseif ($request->has('start_date')) {
                        $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
                        $query->where('created_at', '>=', $startDate);
                } elseif ($request->has('end_date')) {
                        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
                        $query->where('created_at', '<=', $endDate);
                }

        $activities = $query->paginate(10);

        return view('activity_log.index', compact('activities'));
    }
}