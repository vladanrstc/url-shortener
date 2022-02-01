<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("my_urls", ["urls" => Url::where("user_id", Auth::id())->orderBy("created_at", "DESC")->get()]);
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
        $request->validate([
            "original_link" => "required|url",
            "expiration_choice" => "in:days,visits"
        ]);

        // get last created id of a url
        $latest_url_id = Url::orderBy("created_at", "DESC")->first("id");

        // if it's the first Row in the DB, there are now ID's so set it at one
        if(is_null($latest_url_id)) {
            $latest_url_id = 1;
        } else {
            $latest_url_id = $latest_url_id->id + 1;
        }

        // create a shortened url object
        $url = new Url([
            "original_link" => $request->original_link,
            "generated_link" => env("APP_URL") . "/g/" . Str::random(8) . "-" . $latest_url_id,
        ]);

        if($request->expiration_choice == "days") {
            $request->validate([
                "expires_in_days" => "sometimes|numeric|min:1|max:5"
            ]);
            $url->date_of_expiration = Carbon::now()->addDays($request->expires_in_days);
        } else {
            $request->validate([
                "number_of_allowed_visits" => "sometimes|numeric|min:1|max:50"
            ]);
            $url->number_of_allowed_visits = $request->number_of_allowed_visits;
        }

        // if the user is logged in, store him as well so we can keep a track of all of his url's
        $user = Auth::user() ?? Auth::guard("web")->user();
        if(!is_null($user)) {
            $url->user_id = $user->id;
        }

        $url->save();

        return view("url_added", ["url" => $url]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        //
    }
}
