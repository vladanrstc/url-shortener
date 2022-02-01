<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class RedirectController extends Controller
{

    public function redirect_to_url($last_segment) {
        $url = Url::where("generated_link", "LIKE", env("APP_URL") . "/g/" . $last_segment)->firstOrFail();

        // check if the link is expired
        if(!is_null($url->date_of_expiration)) {
            if(Carbon::now()->gt($url->date_of_expiration)) {
                abort(404);
            }
        } else {
            if($url->number_of_visits >= $url->number_of_allowed_visits) {
                abort(404);
            } else {
                $url->number_of_visits++;
                $url->save();
            }
        }
        return Redirect::to($url->original_link);
    }

}
