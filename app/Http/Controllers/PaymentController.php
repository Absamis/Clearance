<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Student;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function index()
    {
        $paytype = Setting::where(["category" => 'payment', "session" => session('session'), "level" => session('userlevel')])->get();
        $paid = Transaction::where(['user' => session('user'), 'session' => session('session'), "level" => session('userlevel')])->get(['trans_type', 'transID', 'user']);
        foreach ($paytype as $pkey => $pvalue) {
            foreach ($paid as $key => $value) {
                if ($value["trans_type"] == $pvalue['cat_name']) {
                    unset($paytype[$pkey]);
                }
            }
        }
        StudentController::checkStudentStatus();
        return view("student/payment", ["title" => "Payments", "payment" => $paytype, "paidfee" => $paid]);
    }

    public function paymentDetails(Request $request, $id)
    {
        $trans = Transaction::where("transID", $id)
            ->join("students", "students.studentid", "=", "transactions.user")
            ->select("transactions.*", "students.name", "students.email", "students.matric", "students.department")
            ->first();
        // return $trans;
        return view("student/confirm-page", ["title" => "Payments", "details" => $trans]);
    }
    public function confirmMsg(Request $request)
    {
        $data = $request->validate([
            "type" => ["required", "max: 20"],
            "stid" => ["required"],
        ]);
        $type = Setting::where('catid', $data['type'])->first(['cat_name', 'cat_price']);
        $userdata = Student::where('studentid', $data["stid"])->first(['name', 'matric', 'email', 'session', 'level', 'studentid']);
        return back()->with(['pay-confirm' => true, "data" => $userdata])->withInput(['type' => $type["cat_name"], 'amount' => $type["cat_price"]]);
    }
    public function verifyPayment(Request $request)
    {
        try {
            $ref = $request->input('ref');
            $userinfo = json_decode($request->input('details'), true);
            $url = "https://api.paystack.co/transaction/verify/$ref";
            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer sk_test_b13c1a7afde2c5651aef1919c9973aa2aebedfc5",
                "Cache-Control: no-cache",
            ));

            //So that curl_exec returns the contents of the cURL; rather than echoing it
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute post
            $result = curl_exec($ch);
            // return $userinfo;
            if (Transaction::create([
                'transID' => $ref,
                'user' => $userinfo[0],
                'trans_type' => $userinfo[1],
                'amount' => $userinfo[2],
                'status' => 1,
                'session' => session('session'),
                "level" => session('userlevel')
            ])) {
                return $result;
            }
        } catch (Exception $ex) {
            return array('error' => $ex->getMessage());
        }
    }

    public function showTransaction($id = null)
    {
        // if($id == null){
        //     return;
        // }else{
        //     $tdetails = Transaction
        // }
        return;
    }
}
