<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Notification;
use App\Models\Progress;
use App\Models\Session;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Verify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static function allDepartments()
    {
        $deprt = array("com-sci" => "Computer science", "mass-comm" => "Mass Communication", "com-eng" => "Conmputer engineering", "civil-eng" => "Civil Engineering", "bus-admin" => "Business Administration", "acct" => "Accountancy", "hspt" => "Hospitality", "pharm-tech" => "Pharmaceutical Tech", "slt" => "Science and Laboratory Tech");
        return $deprt;
    }
    public function dashboardProgress()
    {
        $paytype = Setting::where(["category" => 'payment', "session" => session('session'), "level" => session('userlevel')])->get();
        $paidfee = Transaction::where(['user' => session('user'), 'session' => session('session'), "level" => session('userlevel')])->get();
        if (count($paytype) > 0 && (count($paytype) == count($paidfee)))
            $paystatus = 'complete';
        else
            $paystatus = array(count($paytype), count($paidfee));

        $doctype = Setting::where(["category" => 'document', "session" => session('session'), "level" => session('userlevel')])->get();
        $uploads = Document::where(['user' => session('user'), 'session' => session('session'), "level" => session('userlevel'), "status" => 1])->get(['doc_type', 'docid', 'user', 'status']);
        if (count($doctype) > 0 && (count($doctype) == count($uploads)))
            $docstatus = 'complete';
        else
            $docstatus = array(count($doctype), count($uploads));
        // return $docstatus;
        return view('student/dashboard', ["title" => "Dashboard", "paypr" => $paystatus, "docpr" => $docstatus]);
    }
    static function checkStudentStatus()
    {
        $paytype = Setting::where(["category" => 'payment', "session" => session('session'), "level" => session('userlevel')])->get();
        $paidfee = Transaction::where(['user' => session('user'), 'session' => session('session'), "level" => session('userlevel')])->get();
        if (count($paytype) == count($paidfee))
            $status = 1;
        else
            $status = 0;
        Progress::updateOrCreate(
            ["user" => session('user'), "level" => session('userlevel'), "session" => session('session')],
            ["status" => $status]
        );
    }
    public function index()
    {
        //
        $department = self::allDepartments();
        return view('home', ["title" => "signin", "department" => $department]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $data = Validator::make($request->except('_token'), [
            "fullname" => ["required", "regex: /^[a-zA-Z\s]+$/"],
            "email" => ["required", "email"],
            "matric" => ["required", "regex: /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/"],
            "phone" => ["required", "regex: /^[0-9]{11}$/"],
            "department" => ["required", "max: 20"],
            "level" => ["required", "max: 5"],
            "password" => ["required", Password::min(8)->letters()->numbers()],
            // "cpassword" => ["required", "same: password"],
        ], [], []);
        if ($data->fails()) {
            return back()->withErrors($data->errors())->withInput()->with(["failed" => "Error occured during registration"]);
        }
        $data = $data->validated();
        if (DB::table('students')->where('email', $data["email"])->orWhere('matric', $data["matric"])->first()) {
            return back()->with(["failed" => "Account Already exist"]);
        }
        $stid = pageController::getUniqueID(Student::all(["studentid"]), "studentid", 30);
        if (
            Student::create([
                "name" => $data["fullname"],
                "matric" => $data["matric"],
                "department" => $data["department"],
                "level" => $data["level"],
                "email" => $data["email"],
                "phone" => $data["phone"],
                "password" => Hash::make($data["password"]),
                "studentid" => $stid,
                "status" => 1,
                "session" => session('session_date')
            ])
        ) {
            $token = sha1(now() . " " . Str::random(20) . " " . $data["matric"]);
            Verify::create([
                "userid" => $stid,
                "token" => $token
            ]);
            return view('confirm', ["success" => array("head" => "Registration successful", "body" => "Your registration is succssful. A verification link is sent to your mail for account verification")]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $level)
    {
        //
        $sess = null;
        $lvl = array("nd2", "hnd2");
        if (!in_array($level, $lvl))
            return abort(404);
        else {
            if ($request->has('sess')) {
                $details = self::allDepartments();
                $shw = "department";
                $sess = $request->input('sess');
            }
            if ($request->has(['sess', 'dept'])) {
                $details = Student::where(['department' => $request->input('dept'), "session" => $request->input('sess'), "level" => $level])->get(['name', 'studentid']);
                $shw = "student";
            }
            if ($request->getQueryString() == null) {
                $details = Session::all();
                $shw = 'session';
            }
        }
        return view('admin/student', ['title' => "Students", "level" => $level, "sess" => $sess, "show" => $shw, "details" => $details]);
    }

    public function studentRecord(Request $request, $stdid)
    {
        $paystatus = array();
        $docstatus = array();
        if ($request->has(['level', 'sess'])) {
            $stdetails = Student::where(['studentid' => $stdid, "level" => $request->input('level'), "session" => $request->input('sess')])->first();
        } else {
            return abort(404);
        }

        $paytype = Setting::where(["category" => 'payment', "session" => $request->sess, "level" => $request->level])->get();
        $paid = Transaction::where(['user' => $stdid, 'session' => $request->sess, "level" => $request->level])->get(['trans_type', 'transID', 'user']);
        foreach ($paytype as $pkey => $pvalue) {
            $paystatus[$pvalue["cat_name"]]["status"] = 0;
            foreach ($paid as $key => $value) {
                if ($value["trans_type"] == $pvalue['cat_name']) {
                    $paystatus[$pvalue["cat_name"]]["status"] = 1;
                }
            }
        }
        // return $paid;
        $doctype = Setting::where(["category" => 'document', "session" => $request->sess, "level" => $request->level])->get();
        $uploads = Document::where(['user' => session('user'), 'session' => session('session'), "level" => session('userlevel')])->get(['doc_type', 'docid', 'docname', 'status']);
        foreach ($doctype as $pkey => $pvalue) {
            foreach ($uploads as $key => $value) {
                if ($value["doc_type"] == $pvalue['cat_name']) {
                    unset($doctype[$pkey]);
                }
            }
        }
        // return session("session");

        return view('admin/studentpage', ["title" => "Students", "paystatus" => $paystatus, "docstatus" => $uploads, "docpend" => $doctype, "session" => $request->input("session"), "level" => $request->input('level'), "studentdetails" => $stdetails]);
    }

    public function adminDashboard()
    {
        return view("admin/dashboard", ["title" => "Dashboard"]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
    public function sendNotification(Request $request)
    {
        // return $request->all();
        // return "DDD";
        $data = Validator::make($request->except("_token"), [
            "userid" => ["required", "max:30"],
            "session" => "required",
            "message" => ["required", "max:200"]
        ]);
        if ($data->fails()) {
            return back()->withErrors($data->errors())->withInput()->with("error", "Error occured");
        }
        $data = $data->validated();
        $info  = Student::where("studentid", $data["userid"])->first();
        $mid = pageController::getUniqueID(Notification::all(["msgid"]), "msgid", 10);
        Notification::create([
            "user" => $info["studentid"],
            "message" => $data["message"],
            "session" => $info["session"],
            "level" => $info["level"],
            "msgid" => $mid,
        ]);
        return back()->withInput()->with("success", "Notification sent");
    }

    public function Notification(Request $request, $id = null)
    {
        $data = Notification::where("user", session("user"))->orderBy("created_at", "DESC")->get();
        if (!$id)
            return view("student/notification", ["title" => "Notification", "data" => $data, "read" => false]);

        $msg = Notification::where(["user" => session("user"), "msgid" => $id])->first();
        if ($msg)
            return view("student/notification", ["title" => "Notification", "data" => $data, "read" => $msg]);
    }

    public function studentLogout(Request $request)
    {
        if (session("user")) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect("/");
        }
    }
}
