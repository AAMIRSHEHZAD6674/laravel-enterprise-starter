<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        abort_unless(
            auth()->user()->can('activity_logs.view'),
            403
        );

        $activities = Activity::with('causer')
            ->latest()
            ->paginate(20);

        return view('admin.activity-logs.index', compact('activities'));
    }
}