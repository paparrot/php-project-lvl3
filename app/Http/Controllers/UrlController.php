<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $urls = DB::table('urls')
            ->oldest()
            ->paginate(10);

        $checks = DB::table('url_checks')
            ->orderBy('url_id')
            ->latest()
            ->distinct('url_id')
            ->get()
            ->keyBy('url_id');

        return view('urls.index', compact('urls', 'checks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('urls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UrlRequest  $url
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UrlRequest $url)
    {
        $data = $url->validated();
        $parsedUrl = parse_url($data['url']['name']);
        $url = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";

        $existedSite = DB::table('urls')
            ->where('name', $url)
            ->first();


        if (!is_null($existedSite)) {
            flash("Страница уже существует");
            return redirect()->route('urls.show', $existedSite->id);
        }

        $data = [
            'url' => [
                'name' => $url,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        $id = DB::table('urls')->insertGetId($data['url']);
        flash('Страница успешно добавлена')->success();
        return redirect()->route('urls.show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $url = DB::table('urls')->find($id);

        abort_unless($url, 404);

        $checks = DB::table('url_checks')
            ->where('url_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('urls.show', compact('url', 'checks'));
    }
}
