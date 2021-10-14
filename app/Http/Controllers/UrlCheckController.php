<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store($id)
    {
        $url = DB::table('urls')->find($id);
        try {
            $response = Http::get($url->name);
            $document = new Document($response->body());

            $status = $response->status();
            $h1 = optional($document->first('h1'))->text();
            $description = optional($document->first('meta[name="description"]'))->getAttribute('content');
            $keywords = optional($document->first('meta[name="keywords"]'))->getAttribute('content');

            $data = [
                'url_id' => $url->id,
                'status_code' => $status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'h1' => $h1,
                'keywords' => $keywords,
                'description' => $description
            ];

            DB::table('url_checks')
                ->insert($data);

            DB::table('urls')
                ->where('id', $id)
                ->update(['updated_at' => $data['updated_at']]);

            flash('Страница успешно проверена')->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        } finally {
            return redirect()
                ->route('url.show', $url->id);
        }
    }
}
