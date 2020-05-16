<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curriculum;


class CurriculumController extends Controller
{
    public function showall(Request $request)
    {
        return response()->json(Curriculum::all(), 200);
    }
}
