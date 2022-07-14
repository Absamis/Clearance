<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class pageController extends Controller
{
    //
    static function getUniqueID($data = array(), $item = null, $len = 1)
    {
        $seen = true;
        // $err = Str::afterLast(;, 'search')
        while ($seen) {
            $seen = false;
            $id = Str::random($len);
            foreach ($data as $key => $value) {
                if ($value[$item] == $id) {
                    $seen = true;
                }
            }
            if (!$seen)
                return $id;
        }
    }

    public function adminLogin(Request $request)
    {
        $validatedData = Validator::make($request->except(['_token']), [
            'loginid' => 'required',
            'passkey' => 'required'
        ], []);

        if ($validatedData->fails()) {
            return back()->with(['error' => 'Invalid login details']);
        }

        $valids = $validatedData->validated();
        $logins = Admin::where('loginID', $valids['loginid'])->first();
        if ($logins) {
            if (Hash::check($valids['passkey'], $logins['password'])) {
                $request->session()->invalidate();
                session(['adminlogin' => $logins['token'], 'adminonline' => true, 'adid' => $logins['id']]);
                return redirect('/admin/dashboard');
            } else {
                return back()->with(['error' => 'Invalid login details']);
            }
        } else {
            return back()->with(['error' => 'Invalid login details']);
        }
    }

    public function studentLogin(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);
        $email = $data["email"];
        $password = $data["password"];
        $info = Student::where('email', $email)->first();
        if ($info) {
            if (Hash::check($password, $info["password"])) {
                if ($info["status"] == 1) {
                    if (isset(explode(" ", $info["name"])[1]))
                        $nme = explode(" ", $info["name"])[1];
                    else
                        $nme = explode(" ", $info["name"])[0];

                    $request->session()->invalidate();
                    $request->session()->regenerate();
                    session(["stdonline" => true, "user" => $info["studentid"], "userlevel" => $info["level"], "usertype" => "student", "username" => $nme, "session" => $info["session"]]);
                    return redirect('/dashboard');
                } else {
                    return back()->with(["failed" => "This account has not been verified. Check your email for a verification link"]);
                }
            } else {
                return back()->with(["failed" => "Invalid Login details"]);
            }
        } else {
            return back()->with(["failed" => "Account does not exist"]);
        }
    }
    public function createSession(Request $request)
    {
        $data = Validator::make($request->all(), [
            "session" => ["required", "regex: /^[0-9]{4}\/[0-9]{4}$/"],
        ]);
        if ($data->fails()) {
            return back()->with(["error" => "Error occured"]);
        }
        DB::table('sessions')->update(['status' => 0]);
        $data = $data->validated();
        Session::updateOrCreate(
            ["session_date" => $data["session"]],
            ["status" => 1],
        );
        return back()->with(['success' => "Session successfull changed"]);
    }
}
