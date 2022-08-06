<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewsRequest;
use App\Models\Reviews;
use App\Providers\RouteServiceProvider;

class ReviewsConroller extends Controller
{

    protected function create(ReviewsRequest $request)
    {
        Reviews::create([
            'user_id' => $request['user_id'],
            'review' => $request['review'],
        ]);

        return true;
    }
}
