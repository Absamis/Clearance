<?php

namespace App\Http\Middleware;

use App\Http\Controllers\StudentController;
use App\Models\Progress;
use Closure;
use Illuminate\Http\Request;

class DocumentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        StudentController::checkStudentStatus();
        $progress = Progress::where(['user' => session('user'), 'level' => session('userlevel'), 'session' => session('session')])->first(['status']);
        // return $progress;
        if ($progress) {
            if ($progress["status"] < 1) {
                $request->session()->flash('allowdoc', false);
            } else {
                $request->session()->flash('allowdoc', true);
            }
        } else {
            $request->session()->flash('allowdoc', false);
        }
        return $next($request);
    }
}
