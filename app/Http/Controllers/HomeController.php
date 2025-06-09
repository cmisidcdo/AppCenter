<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationDetail;
use App\Models\Application;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function show($id)
    {
        $id = base64_decode($id);
        $appilcation = Application::find($id);
        $detail_raw = ApplicationDetail::where('application_id', $id)->latest();
        $lastest = $detail_raw->first();
        $detail = $detail_raw->skip(1)->take(5)->get();


        return view('public', compact('detail', 'lastest', 'appilcation'));
    }
    public function download($id)
    {
        $id = base64_decode($id);
        $detail = ApplicationDetail::where("id", $id)->first();
        $detail->total_downloads = ($detail->total_downloads + 1);
        $detail->save();

        $file_path = public_path("uploads/$detail->file_location");
        $str = strtolower(str_replace(' ', '_', $detail->application->app_name)) . "-v" . $detail->release_version;
        $file_name = "$str.apk";

        $headers = [
            'Content-Disposition' => 'filename=' . $file_name,
            'Content-Type' => 'application/vnd.android.package-archive',
            'Content-Length' => filesize($file_path),
        ];

        return response()->download($file_path, $file_name, $headers);
    }
}
