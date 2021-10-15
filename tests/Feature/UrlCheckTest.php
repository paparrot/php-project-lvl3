<?php

namespace Tests\Feature;

use Carbon\Carbon;
use DiDom\Document;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $faker = Factory::create();
        $parsedUrl = parse_url($faker->url);
        $url = "{$parsedUrl['scheme']}://{$parsedUrl['host']}";
        $data = [
            'url' => [
                'name' => $url,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ];

        $urlId = DB::table('urls')->insertGetId($data['url']);

        $fakeHTML = file_get_contents(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Fixtures', 'fake.html']));

        if ($fakeHTML === false) {
            throw new \Exception('Не удалось загрузить контент из тестовой страницы');
        }

        Http::fake([$url => Http::response($fakeHTML, 200)]);

        $expectedData = [
            'url_id' => $urlId,
            'status_code' => 200,
            'h1' => 'hello world',
            'description' => 'hello world fake site',
            'keywords' => 'hello, world'
        ];

        $response = $this->post(route('url_checks.store', $urlId));
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
