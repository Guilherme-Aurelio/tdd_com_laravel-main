<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ShoppingList;
use Illuminate\Testing\Fluent\AssertableJson;

class ShoppingListControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_get_shopping_lists_endpoint(): void
    {
        $shoppingLists = ShoppingList::factory(3)->create();

        $response = $this->getJson('/api/shoppingList');

        // dd($response->baseResponse);m

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function (AssertableJson $json) use($shoppingLists){
            $json->whereAllType([
                '0.id' => 'integer',
                '0.name' => 'string',
                '0.description' => 'string'
            ]);

            $json->hasAll(['0.id', '0.name', '0.description']);

            $shoppingList = $shoppingLists->first();

            $json->whereAll([
                '0.id' => $shoppingList->id,
                '0.name' => $shoppingList->name,
                '0.description' => $shoppingList->description,

            ]);
        });
    }

    public function test_get__single_shopping_list_endpoint(): void
    {
        $shoppingList = ShoppingList::factory(1)->createOne();

        $response = $this->getJson('/api/shoppingList/' . $shoppingList->id);

        // dd($response->baseResponse);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use($shoppingList){
            $json->hasAll(['id', 'name', 'description', 'created_at', 'updated_at']);

            $json->whereAllType([
                'id' => 'integer',
                'name' => 'string',
                'description' => 'string'
            ]);            

            $json->whereAll([
                'id' => $shoppingList->id,
                'name' => $shoppingList->name,
                'description' => $shoppingList->description,
            ]);
        });
    }

    public function test_post_shopping_list_endpoint()
    {
        $shoppingList = ShoppingList::factory(1)->makeOne()->toArray();

        $response = $this->postJson('/api/shoppingList/', $shoppingList);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($shoppingList){
            $json->hasAll(['id', 'name', 'description', 'created_at', 'updated_at']);


            $json->whereAll([
                'name' => $shoppingList['name'],
                'description' => $shoppingList['description'],
            ])->etc();
        });

    }

    public function test_put_shopping_list_endpoint()
    {

        ShoppingList::factory(1)->createOne();

        $shoppingList = [
            'name' => 'Novo nome da lista de compras para atualizar',
            'description' => 'Descrição da lista de compras para atualizar'
        ];

        $response = $this->putJson('/api/shoppingList/1', $shoppingList);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($shoppingList){
            $json->hasAll(['id', 'name', 'description', 'created_at', 'updated_at']);


            $json->whereAll([
                'name' => $shoppingList['name'],
                'description' => $shoppingList['description'],
            ])->etc();
        });
    }

    public function test_delete_shopping_list_endpoint()
    {
        ShoppingList::factory(1)->createOne();

        $response = $this->deleteJson('api/shoppingList/1');

        $response->assertStatus(204);
    }



}
