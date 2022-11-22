<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use App\Models\User;
use Illuminate\Http\Request;
use DB, Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $users = User::all();
        $keywords = SearchHistory::select('keyword', DB::raw('count(*) as total'))
            ->groupBy('keyword')
            ->orderBy('total','DESC')
            ->get();
        return view('index',compact('users','keywords'));
    }
    public function home()
    {
        return view('home');
    }

    /* Keyword Search and store keyword as user history*/
    public function search(Request $request){

        try{
        $isAnyFilter = false; // if empty filter request
        $results = SearchHistory::with('user');

        // if search by keyword
        if(isset($request->keyword)){
            $isAnyFilter = true;
            $results = $results->where('keyword', 'LIKE', "%{$request->keyword}%");
           $newKeyword = SearchHistory::create([
                'keyword'=>$request->keyword,
                'user_id'=>\Auth::user()->id,
                'total_match_keywords'=> $results->count()
            ]);
            $results = $results->where('id','!=',$newKeyword->id);
        }

        // filter by users
        if(isset($request->users)){
            $isAnyFilter = true;
            $results = $results->whereIn('user_id',$request->users);
        }

        // filter by existing keyword
        if(isset($request->keywords)){
            $isAnyFilter = true;
            $results = $results->whereIn('keyword',$request->keywords);
        }

        // filter by time range in checkbox
        if(isset($request->time_range)){
            $isAnyFilter = true;
            $maxRange = max($request->time_range);

            //From Yesterday
            if($maxRange==1){
                $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
                $results = $results->whereDate('created_at','>=',$yesterday);
            }

            //From last week
            if($maxRange==2){
                $lastWeek = date("Y-m-d", strtotime( '-7 days' ) );
                $results = $results->whereDate('created_at','>=',$lastWeek);
            }

            //From last month
            if($maxRange==3){
                $lastMonth = date("Y-m-d", strtotime( '-30 days' ) );
                $results = $results->whereDate('created_at','>=',$lastMonth);
            }
        }

        // Time range by start date & end date
            if(isset($request->start_date)){
                $isAnyFilter = true;
                $startDate = date('Y-m-d',strtotime($request->start_date));
                $results = $results->whereDate('created_at','>=',$startDate);
            }
            if(isset($request->end_date)){
                $isAnyFilter = true;
                $endDate = date('Y-m-d',strtotime($request->end_date));
                $results = $results->whereDate('created_at','<=',$endDate);
            }

            if($isAnyFilter){
                $results = $results->get();
            }else{
                $results = [];
            }

        return response()->json($results,201);

        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            return response($e->errorInfo[2],500);
        }

    }
}
