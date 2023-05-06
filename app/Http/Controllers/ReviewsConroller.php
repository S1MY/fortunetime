<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewsRequest;
use App\Models\Reviews;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReviewsConroller extends Controller
{

    protected function create(ReviewsRequest $request)
    {
        $Reviews = Reviews::create([
            'user_id' => $request['user_id'],
            'review' => $request['review'],
        ]);
        $dbname = DB::connection()->getDatabaseName();
        return Hash::make(12345678);
    }
}
