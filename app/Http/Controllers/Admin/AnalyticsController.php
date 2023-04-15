<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified:api', 'role:super-admin']);
    }

    public function index()
    {
    //    $period = Period::days(30);
    //    $metrics_total = 'ga:pageviews';
    //    $metrics_unique = 'ga:uniquePageviews';
    //    $dimensions_results = [
    //        'dimensions' => 'ga:pagePath',
    //        'filters' => 'ga:pagePath==/results',
    //    ];
    //    $dimensions_home = [
    //        'dimensions' => 'ga:pagePath',
    //        'filters' => 'ga:pagePath==/',
    //    ];
    //    $total_results = Analytics::performQuery($period, $metrics_total, $dimensions_results);
    //    $unique_results = Analytics::performQuery($period, $metrics_unique, $dimensions_results);

    //    $total_home = Analytics::performQuery($period, $metrics_total, $dimensions_home);
    //    $unique_home = Analytics::performQuery($period, $metrics_unique, $dimensions_home);
    //    $analyticsData = Analytics::fetchMostVisitedPages(Period::days(30));
    //    return response()->json([
    //        "total_results" => $total_results,
    //        "unique_results" => $unique_results,
    //        "total_home" => $total_home,
    //        "unique_home" => $unique_home,
    //        "analyticsData" => $analyticsData,
    //    ]);
        $top = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
        return response($top);
    }
    public function topContent(){
        $period = Period::days(30);
        $metrics="ga:pageviews,ga:uniquePageviews,ga:timeOnPage,ga:bounces,ga:entrances,ga:exits";
        $dimensions_results = [
            'dimensions' => 'ga:pagePath',
            'sort' => '-ga:pageviews'
        ];
        $total_results = Analytics::performQuery($period,$metrics,$dimensions_results);
        return response($total_results);
    }
    public function topBrowser(){
        $topBrower = Analytics::fetchTopBrowsers(Period::days(30));
        return response($topBrower);
    }
    public function mobileTraffic(){
        $period = Period::days(30);
        $metrics="ga:sessions,ga:pageviews,ga:sessionDuration";
        $dimensions_results = [
            'dimensions' => 'ga:mobileDeviceInfo,ga:source',
            'segment' => 'gaid::-14'
        ];
        $total_results = Analytics::performQuery($period,$metrics,$dimensions_results);
        return response($total_results);
    }
    public function organicSearch()
    {
        $period = Period::days(30);
        $metrics = "ga:pageviews,ga:sessionDuration,ga:exits";
        $dimensions_results = [
            'dimensions' => 'ga:source',
            'sort' => '-ga:pageviews',
            'filters' => 'ga:medium == organic'
        ];
        $total_results = Analytics::performQuery($period,$metrics,$dimensions_results);
        return response($total_results);
    }
    public function keyWords(){
        $period = Period::days(30);
        $metrics = "ga:sessions";
        $dimensions_results = [
                'sort' => '-ga:sessions',
        ];
        $total_results = Analytics::performQuery($period,$metrics,$dimensions_results);
        return response($total_results);
    }
}
