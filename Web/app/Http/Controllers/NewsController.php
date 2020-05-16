<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    public function showall(Request $request)
    {
        return response()->json(News::all(), 200);
    }
}
