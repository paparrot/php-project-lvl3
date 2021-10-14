<?php

namespace Tests\Feature;

use App\Models\Url;
use Facade\FlareClient\Truncation\AbstractTruncationStrategy;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UrlTest extends TestCase
{
    private $data;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();
        $url = parse_url($faker->url);
        $time = Carbon::now()->toDateTimeString();
        $this->data = [
            'url' => [
                'name' => "{$url['scheme']}://{$url['host']}",
                'created_at' => $time,
                'updated_at' => $time
            ]
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $responce = $this->get(route('urls.index'));
        $responce->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('urls.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = $this->data;
        $response = $this->post(route('urls.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', $data['url']);
    }

    public function testShow()
    {
        $url = $this->data['url'];
        $id = DB::table('urls')->insertGetId($url);
        $response= $this->get(route('urls.show', ['id' => $id]));
        $response->assertOk();
    }
}
