<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ApplicationDetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_location' => 'required',
        ]);
        $application_id = Session::get("APP_ID");

        $old = ApplicationDetail::where("application_id", $application_id)->orderBy("id", "DESC")->first();
        $application = new ApplicationDetail();
        $application->application_id = $application_id;
        $application->release_number = $old ? $old->release_number + 1 : 1;
        $application->release_version = $request->release_version;
        $application->release_notes = $request->release_notes;
        $application->is_public = $request->is_public;
        $application->is_active = $request->is_active;
        $application->created_by = auth()->user()->id;

        $file = $request->file('file_location');
        $path = $file->store('applications', 'public');

        $application->file_location = $path;
        $application->file_size = $request->file('file_location')->getSize();
        $application->save();
        return back()->with("File uploaded successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicationDetail $applicationDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicationDetail $applicationDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApplicationDetail $applicationDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicationDetail $applicationDetail)
    {
        //
    }
    public function download($id)
    {
        $detail = ApplicationDetail::where("id", $id)->first();
        $detail->total_downloads = ($detail->total_downloads + 1);
        $detail->save();

        $file_path = public_path("uploads/$detail->file_location");
        // $file_name = "app-release-$detail->id.apk";
        return response()->download($file_path);
    }
}
