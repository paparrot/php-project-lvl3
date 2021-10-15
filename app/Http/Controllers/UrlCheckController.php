<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UrlCheckController extends Controller
{
    public function store($id)
    {
        $url = DB::table('urls')->find($id);

        abort_unless($url, 404);

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
                'h1' => Str::limit($h1, 250),
                'keywords' => Str::limit($keywords, 250),
                'description' => Str::limit($description, 250)
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
                ->route('urls.show', $url->id);
        }
    }
}
