<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Progress;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    // public $allow;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // StudentController::checkStudentStatus();
        $doctype = Setting::where(["category" => 'document', "session" => session('session'), "level" => session('userlevel')])->get();
        $uploads = Document::where(['user' => session('user'), 'session' => session('session'), "level" => session('userlevel')])->get(['doc_type', 'docid', 'user', 'status']);
        foreach ($doctype as $pkey => $pvalue) {
            foreach ($uploads as $key => $value) {
                if ($value["doc_type"] == $pvalue['cat_name']) {
                    unset($doctype[$pkey]);
                }
            }
        }
        return view('student/document', ["title" => "Documents", "document" => $doctype, "upload" => $uploads]);
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

    public function verifyDocument($id){
        if(Document::where(['docid' => $id])->first())
            Document::where(['docid' => $id])->update(['status' => 1]);
        return back();
    }
    public function declineDocument($id){
        if(Document::where(['docid' => $id])->first())
        Document::where(['docid' => $id])->update(['status' => -1]);
        return back();
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
            "doctype" => ["required", "max: 20"],
            "file" => ["required", "file", "mimes:pdf", "max:2000"],
        ], ["file.max" => "The file size should not be greater than 2MB", "file.mimes" => "Only pdf file is allowed"], ["doctype" => "document type"])->validate();
        // if ($data->fails()) {
        //     return back()->withErrors($data->errors())->withInput();
        // }
        try {
            $fileup = $request->file('file');
            $filename = pageController::getUniqueID(Document::all(['docname']), "docname", 25);
            $filename .= '.pdf';
            $id = pageController::getUniqueID(Document::all(['docid']), "docid", 20);
            if ($request->file('file')->storeAs('public', $filename)) {
                Document::create([
                    "session" => session('session'),
                    "level" => session('userlevel'),
                    "user" => session('user'),
                    "doc_type" => $data["doctype"],
                    "docname" => $filename,
                    "docid" => $id
                ]);
                return redirect("/documents")->with(["success" => "Document uploaded"]);
            } else {
                return false;
            }
        } catch (Exception $x) {
            return $x->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $documen, $id)
    {
        //
        $info = Document::where(['docid' => $id])->first();
        if (!$info) {
            return abort(404);
        }
        return back()->withInput(['docid' => $info["docid"], 'docname' => $info['docname'], "doctype" => $info["doc_type"]])->with(['editdoc' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
        $data = Validator::make($request->except('_token'), [
            "docid" => "required",
            "prevfile" => "required",
            "file" => ["file", "mimes:pdf", "max:2000"]
        ], ["file.max" => "The file size should not be greater than 2MB", "file.mimes" => "Only pdf file is allowed"], ["doctype" => "document type"]);
        if($data->fails()){
            // return abort(404);
            $info = Document::where(['docid' => $request->input('docid')])->first();
            if (!$info) {
                return abort(404);
            }
        // return back()->withInput(['docid' => $info["docid"], 'docname' => $info['docname'], "doctype" => $info["doc_type"]])->with(['editdoc' => true]);
            return redirect("/documents")->withInput(['docid' => $info["docid"], 'docname' => $info['docname'], "doctype" => $info["doc_type"]])->withErrors($data->errors())->with(['editdoc' => true, "error" => "Error occured"]);
        }
        $data = $data->validated();
        try {
            if (isset($data["file"])) {
                $fileup = $request->file('file');
                $filename = pageController::getUniqueID(Document::all(['docname']), "docname", 25);
                $filename .= '.pdf';
            } else {
                $filename = $request->input("prevfile");
            }
            if($filename != $request->input('prevfile')){
                if(File::delete(Storage::url($request->input("prevfile"))))
                    $request->file('file')->storeAs('public', $filename);
                else {
                    return back()->with(["error" => "Error occured"]);
                }
            }
            if (
                Document::where(['docid' => $data["docid"]])->update([
                    "status" => 0,
                    "docname" => $filename
                ])
            ) {
                return redirect("/documents")->with(["success" => "Document changed"]);
            } else {
                return false;
            }
        } catch (Exception $x) {
            return $x;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document, $id)
    {
        //
        if (Document::where(["docid"=> $id])->first()) {
            Document::where(["docid"=> $id])->delete();
            return back()->with(['success' => "Document removed"]);
        } else {
            return abort(404);
        }
    }
}
