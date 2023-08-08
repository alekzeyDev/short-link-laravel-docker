<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $link = Link::getDefaultLink();

        return View::make('links.index')
            ->with([
                'link' => $link,
                'labels' => Link::$LABELS,
                'create_url' => Link::CREATE_URL
            ]);
    }

    /**
     * Redirect by real url.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getShortLink($token = false)
    {
        if (empty($token))
            return abort(404);

        $link = Link::query()
            ->where('token',$token)
            ->first();

        if (!$link || !$link->valid())
            return abort(404);

        return Redirect::to($link->url);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Request data validation
        $request->validate([
            'name'          => [
                'required',
                'string',
                'max:255'
            ],
            'url'         => [
                'required',
                'url:http,https',
                'max:255'
            ],
            'limit'        => [
                'integer',
                'min:0',
            ],
            'valid_hours'       => [
                'integer',
                'min:1',
                'max:24'
            ],
        ],[],Link::$LABELS);

        // Create link
        $link = new Link();
        $link->name = $request->name;
        $link->url = $request->url;
        $link->limit = $request->limit;
        $link->valid_hours = $request->valid_hours;
        if ($link->save()) {

            //Success
            return response()->json([
                'message' => 'A short link was created',
                'link' => url($link->short_link)
            ]);
        }

        //Error
        return response()->json([
            'message' => 'Short link generation error((('
        ],500);
    }
}
