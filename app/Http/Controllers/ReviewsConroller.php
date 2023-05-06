<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewsRequest;
use App\Models\Reviews;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;

class ReviewsConroller extends Controller
{

    protected function create(ReviewsRequest $request)
    {
        $Reviews = Reviews::create([
            'user_id' => $request['user_id'],
            'review' => $request['review'],
        ]);
        $dbname = DB::connection()->getDatabaseName();
        return "Connected successfully to the database. Database name is :".$dbname;
    }
}
