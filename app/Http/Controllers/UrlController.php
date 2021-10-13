<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
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
        $urls = DB::table('urls')->orderBy('id')->get()->toArray();
        return view('url.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('url.create');
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
        $host = parse_url($data['url']['name'], PHP_URL_HOST);
        $scheme = parse_url($data['url']['name'], PHP_URL_SCHEME);
        $siteName = "{$scheme}://{$host}";
        $existHosts = DB::table('urls')
            ->where('name', 'like', "$siteName")
            ->get()
            ->toArray();
        $isExists = !empty($existHosts);
        if ($isExists) {
            flash("Сайт уже существует");
            return redirect()->route('url.index');
        }
        $item = [
            'name' => $siteName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        DB::table('urls')->insert($item);
        flash('Сайт добавлен');
        return redirect()->route('url.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        [$url] = DB::table('urls')->where('id', $id)->get()->toArray();
        return view('url.show', compact('url'));
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
