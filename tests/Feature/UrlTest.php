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
    use RefreshDatabase;

    private array $data;

    /**
     * Setup.
     *
     * @return void
     */
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
     * Index page test.
     *
     * @return void
     */
    public function testIndex()
    {
        $responce = $this->get(route('urls.index'));
        $responce->assertOk();
    }

    /**
     * Create page test.
     *
     * @return void
     */
    public function testCreate()
    {
        $response = $this->get(route('urls.create'));
        $response->assertOk();
    }

    /**
     * Store test.
     *
     * @return void
     */
    public function testStore()
    {
        $data = $this->data;
        $time = Carbon::now()->toDateTimeString();
        $data['url']['created_at'] = $time;
        $data['url']['updated_at'] = $time;
        $response = $this->post(route('urls.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('urls', $data['url']);
    }

    /**
     * Show page test.
     *
     * @return void
     */
    public function testShow()
    {
        $url = $this->data['url'];
        $id = DB::table('urls')->insertGetId($url);
        $response = $this->get(route('urls.show', ['id' => $id]));
        $response->assertOk();
    }
}
