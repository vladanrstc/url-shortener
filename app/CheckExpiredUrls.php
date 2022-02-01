<?php

namespace App;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckExpiredUrls
{
    public function __invoke() {
        Url::whereRaw("number_of_visits >= number_of_allowed_visits")
            ->orWhere("date_of_expiration", "<", Carbon::now(). "")
            ->delete();
    }
}
