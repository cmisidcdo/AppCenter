<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
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
        $applications = Application::all();
        return view('home', compact('applications'));
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
            'app_name' => 'required',
            'release_type' => 'required',
            'os_type' => 'required',
            'app_icon' => 'required|mimes:jpg,png|max:2048',
        ]);

        $application = new Application();
        $application->app_name = $request->app_name;
        $application->release_type = $request->release_type;
        $application->os_type = $request->os_type;
        $application->created_by = auth()->user()->id;

        $file = $request->file('app_icon');
        $path = $file->store('uploads', 'public');

        $application->app_icon = $path;
        $application->save();
        return back()->with("File uploaded successfully!");

        // $url = Storage::url("uploads/{$filename}");

        // return view('file.show', ['url' => $url]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        Session::put("APP_ID", $id);
        $application = Application::find($id);
        $application_details = ApplicationDetail::where("application_id", $id)->orderBy("created_at", "DESC")->get();
        return view('app-details', compact('application', 'application_details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
