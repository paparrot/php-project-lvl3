<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlCheckController extends Controller
{
    public function store($id)
    {
        [$url] = DB::table('urls')->where('id', $id)->get('id');

        $data = [
            'url_id' => $url->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        DB::table('url_checks')->insert($data);
        DB::table('urls')->where('id', $id)->update(['updated_at' => $data['updated_at']]);
        flash('Страница успешно проверена');
        return redirect()->route('url.show', $url->id);
    }
}
