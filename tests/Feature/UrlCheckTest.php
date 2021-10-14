<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlCheckTest extends TestCase
{
    private $id;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();
        $parsedUrl = parse_url($faker->url);
        $url = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";
        $time = Carbon::now()->toDateTimeString();
        $data = [
            'url' => [
                'name' => $url,
                'created_at' => $time,
                'updated_at' => $time
            ]
        ];
        DB::table('urls')->insert($data['url']);
        $this->id = DB::table('urls')->where('name', $url)->first()->id;
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $urlId = $this->id;
        $time = Carbon::now();
        $data = [
            'url_id' => $urlId,
            'created_at' => $time,
            'updated_at' => $time
        ];

        $response = $this->post(route('url_check.store', $urlId), $data );

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', $data);

        $updatedAt = DB::table('urls')->where('id', $urlId)->get('updated_at')->first()->updated_at;
        $this->assertEquals($time, $updatedAt);
    }
}
