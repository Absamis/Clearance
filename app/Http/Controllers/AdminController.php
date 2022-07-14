<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    //
    public function adminLogout(Request $request)
    {
        if (session("adminlogin")) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect("/admin/login");
        } else {
            return back();
        }
    }
    public function addNewAdmin(Request $request)
    {
    }

    public function changePassword(Request $request)
    {
        $data = Validator::make($request->except("_token"), [
            "newpass" => ["required", "max:20", Password::min(8)->letters()->numbers()],
            "oldpass" => "required",
            "cpass" => ["required", "same:newpass"]
        ], [], ["oldpass" => "old password", "newpass" => "new password", "cpass" => "confirm password"]);
        if ($data->fails()) {
            return back()->withErrors($data->errors())->with(["error" => "Error occured, Try again later"]);
        }
        // return $data->validated();
        $info = Admin::where("token", session("adminlogin"))->first();
        // return $info;
        if (Hash::check($data->validated()["oldpass"], $info["password"])) {
            Admin::where("token", session("adminlogin"))->update([
                "password" => Hash::make($data->validated()["newpass"])
            ]);
            return back()->with("success", "Password changed");
        } else {
            return back()->with("error", "old password is incorrect");
        }
    }
}
