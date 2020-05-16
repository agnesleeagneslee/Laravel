<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
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
            return response()->json([''], 403); //403:沒有權限存取(登入失敗)
        }

        if ($user->user_password == $password) {
            $page = "/";
            switch ($user->user_status) {
                case 1:
                    $page = "school/views/admin/dashboard.php";
                    break;
                case 2:
                    $page = "school/views/teacher/dashboard.php";
                    break;
                case 3:
                    $page = "school/views/student/dashboard.php";
                    break;
            }
            // $token = $user->createToken('Token Name')->accessToken;
            return response()->json([$page . '?id=' . $user->id], 200); //200:OK成功
        } else {
            return response()->json([''], 500); //500:內部錯誤
        }
    }

    public function forgetPW(Request $request)
    {
        try {
            $newPW = self::create_guid();
            $mailObj = [
                'title' => "翻轉教室-忘記密碼",
                'body' => "您的新密碼是:" . $newPW
            ];
            Mail::to('agneslee015@hotmail.com')->send(new \App\Mail\SendMail($mailObj));
            return response()->json(['OK'], 200);
        } catch (ModelNotFoundException $th) {
            return response()->json([$th], 403);
        }
        // $username = $request->input('forgetUsername');
        // $email = $request->input('forgetEmail');

        // try {
        //     $user = User::findOrFail($username);
        // } catch (ModelNotFoundException $th) {
        //     return response()->json([''], 403);
        // }

        // if ($user->email == $email) {
        //     $newPW = com_create_guid();
        //     $mailObj = [
        //         'fromemail' => "agneslee015@gmail.com",
        //         'fromname' => "Flipped Classroom",
        //         'toemail' => "agneslee015@gmail.com", //資料庫email是假資料,測試要寄到真信箱
        //         'toname' => $user->user_cname,
        //         'subject' => "翻轉教室-忘記密碼",
        //         'content' => "您的新密碼是:" . $newPW
        //     ];
        //     self::sendEmail($mailObj);
        //     return response()->json([''], 200);
        // } else {
        //     return response()->json([''], 403);
        // }
    }

    private function sendEmail($mailObj)
    {
        Mail::raw($mailObj['content'], function ($message) use ($mailObj) {
            $message->from($mailObj['fromemail'], $mailObj['fromname']);
            $message->to($mailObj['toemail'], $mailObj['toname'])->subject($mailObj['subject']);
        });
    }
    function create_guid()
    { // Create GUID (Globally Unique Identifier)
        $guid = '';
        $namespace = rand(11111, 99999);
        $uid = uniqid('', true);
        $data = $namespace;
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash,  0,  8) . '-' .
            substr($hash,  8,  4) . '-' .
            substr($hash, 12,  4) . '-' .
            substr($hash, 16,  4) . '-' .
            substr($hash, 20, 12);
        return $guid;
    }
}
