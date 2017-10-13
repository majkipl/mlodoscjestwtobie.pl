<?php

namespace App\Http\Controllers;

use App\Models\Application;

class ConfirmController extends Controller
{
    public function application(Application $application, string $token)
    {
        if (!$token || $application->token !== $token) {
            abort(404);
        }

        $application->token = null;
        $application->save();

        if ($application->contest) {
            return redirect()->route('front.thx.contest');
        } else {
            return redirect()->route('front.thx.promotion');
        }

    }
}
