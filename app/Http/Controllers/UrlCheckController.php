<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store($id)
    {
        $url = DB::table('urls')->where('id', $id)->first();
        $response = Http::get($url->name);
        $status = $response->status();
        $data = [
            'url_id' => $url->id,
            'status_code' => $status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        DB::table('url_checks')->insert($data);
        DB::table('urls')->where('id', $id)->update(['updated_at' => $data['updated_at']]);
        flash('Страница успешно проверена');
        return redirect()->route('url.show', $url->id);
    }
}
