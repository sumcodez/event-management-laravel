<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getChartData()
    {
        // Fetch counts from each table
        $eventsCount = DB::table('events')->count();
        $usersCount = DB::table('users')->count();
        $venuesCount = DB::table('venues')->count();
        $attendeeCount = DB::table('attendees')->count();

        // Prepare data for the chart
        $data = [
            ['category' => 'Events', 'value' => $eventsCount],
            ['category' => 'Users', 'value' => $usersCount],
            ['category' => 'Venues', 'value' => $venuesCount],
            ['category' => 'Registrations', 'value' => $attendeeCount],
        ];

        // Return data as JSON
        return response()->json($data);
    }



    public function getBarChartData()
    {
        // Fetch months and counts for each table
        $eventsData = DB::table('events')
            ->select(DB::raw('DATE_FORMAT(date, "%M") as month, COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(date)'))
            ->get();
    
        $usersData = DB::table('users')
            ->select(DB::raw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();
    
        $venuesData = DB::table('venues')
            ->select(DB::raw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();
    
        $attendeesData = DB::table('attendees')
            ->join('events', 'attendees.event_id', '=', 'events.id') // Join with events table
            ->select(DB::raw('DATE_FORMAT(events.date, "%M") as month, COUNT(attendees.id) as count')) // Group by month using events.date
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(events.date)')) // Order by the actual month
            ->get();
    
        // Collect all unique months across all datasets
        $allMonths = collect()
            ->merge($eventsData->pluck('month'))
            ->merge($usersData->pluck('month'))
            ->merge($venuesData->pluck('month'))
            ->merge($attendeesData->pluck('month'))
            ->unique()
            ->sortBy(function ($month) {
                return \Carbon\Carbon::parse($month)->month; // Order by actual month
            })
            ->values();
    
        // Map data for each dataset, ensuring all months are included
        $eventsCounts = $allMonths->map(function ($month) use ($eventsData) {
            return $eventsData->firstWhere('month', $month)->count ?? 0;
        });
    
        $usersCounts = $allMonths->map(function ($month) use ($usersData) {
            return $usersData->firstWhere('month', $month)->count ?? 0;
        });
    
        $venuesCounts = $allMonths->map(function ($month) use ($venuesData) {
            return $venuesData->firstWhere('month', $month)->count ?? 0;
        });
    
        $attendeesCounts = $allMonths->map(function ($month) use ($attendeesData) {
            return $attendeesData->firstWhere('month', $month)->count ?? 0;
        });
    
        // Prepare datasets
        $datasets = [
            [
                'label' => 'Events',
                'backgroundColor' => 'rgba(60,141,188,0.9)',
                'data' => $eventsCounts
            ],
            [
                'label' => 'Users',
                'backgroundColor' => 'rgba(210, 214, 222, 1)',
                'data' => $usersCounts
            ],
            [
                'label' => 'Venues',
                'backgroundColor' => 'rgba(0,192,239,1)',
                'data' => $venuesCounts
            ],
            [
                'label' => 'Registrations',
                'backgroundColor' => 'rgba(0,166,90,1)',
                'data' => $attendeesCounts
            ]
        ];
    
        // Return response
        return response()->json([
            'labels' => $allMonths,
            'datasets' => $datasets
        ]);
    }
    
}
