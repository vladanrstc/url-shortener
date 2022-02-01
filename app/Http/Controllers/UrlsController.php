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
        return view("my_urls", ["urls" => Url::where("user_id", Auth::id())->get()]);
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
        $result_of_validations = $request->validate([
            "original_link" => "required|url",
            "number_of_allowed_visits" => "sometimes|numeric|min:1|max:50",
            "expires_in_days" => "sometimes|numeric|min:1|max:5"
        ]);

        // if for some reason, no value is sent for either date of expiration AND number of visits
        if(is_null($result_of_validations['number_of_allowed_visits']) && is_null($result_of_validations['expires_in_days'])) {
            throw ValidationException::withMessages(['You must pass number of allowed visit or expires in days']);
        }

        // get last created id of a url
        $leatest_url_id = Url::orderBy("created_at", "DESC")->first("id");

        // if it's the first Row in the DB, there are now ID's so set it at one
        if(is_null($leatest_url_id)) {
            $leatest_url_id = 1;
        } else {
            $leatest_url_id = $leatest_url_id->id + 1;
        }

        // create a shortened url obj
        $url = new Url([
            "original_link" => $request->original_link,
            "generated_link" => env("APP_URL") . "/g/" . Str::random(8) . "-" . $leatest_url_id,
        ]);

        if(!is_null($request->expires_in_days)) {
            $url->date_of_expiration = Carbon::now()->addDays($request->expires_in_days);
        } else {
            $url->number_of_allowed_visits = $request->number_of_allowed_visits;
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
