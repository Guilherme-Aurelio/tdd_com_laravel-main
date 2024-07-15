<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ShoppingList;
use App\Models\ListItem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class MySQLConnectionTest extends TestCase
{
    use RefreshDatabase;
    public function test_mysql_application_database_connection()
    {
        Config::set('database.default', 'mysql');
        Config::set('database.connections.mysql.host', '127.0.0.1');
        Config::set('database.connections.mysql.port', env('DB_PORT'));
        Config::set('database.connections.mysql.database', 'laravel');
        Config::set('database.connections.mysql.username', env('DB_USERNAME'));
        Config::set('database.connections.mysql.password', env('DB_PASSWORD'));

        $this->assertEquals('127.0.0.1', Config::get('database.connections.mysql.host'));
        $this->assertEquals('3306', Config::get('database.connections.mysql.port'));
        $this->assertEquals('laravel', Config::get('database.connections.mysql.database'));
        $this->assertEquals('root', Config::get('database.connections.mysql.username'));
        $this->assertEquals('', Config::get('database.connections.mysql.password'));
        $this->assertEquals('mysql', Config::get('database.default'));


        $this->assertTrue(DB::connection()->getPdo() != null);
    }

    public function test_create_shopping_list_with_items()
    {
        $shoppingList = ShoppingList::factory()->create();

        $items = ListItem::factory()->count(3)->create(['shopping_list_id' => $shoppingList->id]);

        $this->assertCount(3, $shoppingList->items);
    }

    public function test_fetch_data_from_external_api()
    {
        Http::fake([
            'external-api.com/*' => Http::response(['data' => 'Sample Data'], 200)
        ]);

        $response = Http::get('https://external-api.com/data');

        $this->assertEquals('Sample Data', $response->json('data'));
    }

    public function test_migrations()
    {
        $this->artisan('migrate', ['--database' => 'mysql']);

        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('password_reset_tokens'));
        $this->assertTrue(Schema::hasTable('failed_jobs'));
        $this->assertTrue(Schema::hasTable('personal_access_tokens'));
        $this->assertTrue(Schema::hasTable('shopping_lists'));
        $this->assertTrue(Schema::hasTable('list_items'));
    }

}
