<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvertController extends Controller
{
    /**
     * Fallback controller to satisfy any stale non-namespaced references to
     * "AdvertController". This avoids a BindingResolutionException while the
     * root cause (a misplaced route or cached reference) is investigated.
     *
     * By default this will abort with 404; the method below can be extended to
     * delegate to the correct controller if desired.
     */
    public function __invoke(Request $request)
    {
        abort(404);
    }

    /**
     * If a stale route points '/' to AdvertController@show, forward it to the
     * real home controller so the site still responds as expected.
     */
    public function show(Request $request)
    {
        return app(\App\Http\Controllers\HomeController::class)->index();
    }
}
