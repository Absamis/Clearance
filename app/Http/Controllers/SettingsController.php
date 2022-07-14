<?php

namespace App\Http\Controllers;

use App\Models\Setting;
// use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($level = null)
    {
        //
        if ($level == null)
            return view("admin/setpage", ["title" => "Settings"]);
        elseif ($level == "security")
            return view("admin/change-pass", ["title" => "Settings"]);
        elseif ($level == "sub-admin")
            return view("admin/add-admin", ["title" => "Settings"]);
        else {
            $lvl = array("nd2", "hnd2");
            if (!in_array($level, $lvl))
                return abort(404);

            $payment = Setting::where(['category' => "payment", "level" => $level, "session" => session("session_date")])->get();
            $document = Setting::where(['category' => "document", "level" => $level, "session" => session("session_date")])->get();
            return view('admin/settings', ["title" => "Settings", "level" => $level, "payment" => $payment, "document" => $document]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->input('cat') == "payment" || $request->input('cat') == "document") {
            if ($request->input('cat') == "payment")
                $paydata = Validator::make($request->all(), [
                    "level" => ["required"],
                    "cat" => ["required"],
                    "ptype" => ["required", "max: 30"],
                    "amount" => ["required", "integer"]
                ], [], ["ptype" => "Payment type"]);
            else if ($request->input('cat') == "document")
                $paydata = Validator::make($request->all(), [
                    "level" => ["required"],
                    "cat" => ["required"],
                    "dtype" => ["required", "max: 30"],
                ], [], ["dtype" => "document name"]);

            if ($paydata->fails()) {
                return redirect()->route('settings', $paydata->validated()["level"])->withErrors($paydata->errors())->withInput()->with(["error" => "Error occured. Try again"]);
            }
            $paydata = $paydata->validated();
            if ($paydata["cat"] == "payment") {
                $tp = $paydata["ptype"];
                $pr = $paydata["amount"];
            } else if ($paydata["cat"] == "document") {
                $tp = $paydata["dtype"];
                $pr = null;
            }
            $datainfo = Setting::where(['session' => session('session_date'), "level" => $paydata["level"], "category" => $paydata["cat"], "cat_name" => $tp])->first();
            if ($datainfo) {
                return redirect()->route('settings', $paydata["level"])->withInput()->with(["failed" => "Details already in existence"]);
            }
            $id = pageController::getUniqueID(Setting::all('catid'), "catid", 20);
            Setting::create([
                "session" => session("session_date"),
                "category" => $paydata["cat"],
                "cat_name" => $tp,
                "cat_price" => $pr,
                "level" => $paydata["level"],
                "catid" => $id
            ]);
            return redirect()->route('settings', $paydata["level"])->with(["success" => "New details added"]);
        } else {
            return abort(419);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
