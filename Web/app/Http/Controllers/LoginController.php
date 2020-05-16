<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoginController extends Controller
{
    public function showall(Request $request)
    {
        return response()->json(User::all(), 200);
    }
    public function checkLogin(User $user, Request $request)
    {

        return response()->json($user, 200);
    }
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $user = User::findOrFail($username);
        } catch (ModelNotFoundException $th) {
            return response()->json([''], 500);
        }

        if ($user->user_password == $password) {
            $page="/";
            switch ($user->user_status) {
                case 1:
                    $page="views/admin/dashboard.php";
                    break;
                case 2:
                    $page="views/teacher/dashboard.php";
                    break;
                case 3:
                    $page="views/student/dashboard.php";
                    break;
            }
            // $token = $user->createToken('Token Name')->accessToken;
            return response()->json([$page.'?id='.$user->id], 200);
        } else {
            return response()->json([''], 500);
        }
    }
}
