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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls')
            ->orderBy('id')
            ->get()
            ->each(fn ($url) => $url->status_code = DB::table('url_checks')
                ->where('url_id', $url->id)
                ->orderByDesc('id')
                ->select('status_code')
                ->first()
                ->status_code ?? '')
            ->all();
        return view('urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('urls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UrlRequest $url)
    {
        $data = $url->validated();
        $parsedUrl = parse_url($data['url']['name']);
        $url = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";

        $existedSite = DB::table('urls')
            ->where('name', $url)
            ->first();

        if ($existedSite) {
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = DB::table('urls')->find($id);

        abort_unless($url, 404);

        $checks = DB::table('url_checks')
            ->where('url_id', $id)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        return view('urls.show', compact('url', 'checks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
