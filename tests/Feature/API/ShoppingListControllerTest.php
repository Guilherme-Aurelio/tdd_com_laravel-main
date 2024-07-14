<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShoppingList;

class ShoppingListFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_shopping_lists()
    {
        $shoppingLists = ShoppingList::factory()->count(3)->create();

        $response = $this->get('/api/shoppingList');

        $response->assertStatus(200)
                 ->assertJson($shoppingLists->toArray());
    }

    public function test_can_show_shopping_list()
    {
        $shoppingList = ShoppingList::factory()->create();

        $response = $this->get('/api/shoppingList/' . $shoppingList->id);

        $response->assertStatus(200)
                 ->assertJson($shoppingList->toArray());
    }

    public function test_can_store_shopping_list()
    {
        $data = [
            'name' => 'New Shopping List',
            'description' => 'Description of the new shopping list',
        ];

        $response = $this->post('/api/shoppingList', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }

    public function test_can_update_shopping_list()
    {
        $shoppingList = ShoppingList::factory()->create();
        $newData = [
            'name' => 'Updated Shopping List Name',
            'description' => 'Updated description of the shopping list',
        ];

        $response = $this->put('/api/shoppingList/' . $shoppingList->id, $newData);

        $response->assertStatus(200)
                 ->assertJsonFragment($newData);
    }

    public function test_can_delete_shopping_list()
    {
        $shoppingList = ShoppingList::factory()->create();

        $response = $this->delete('/api/shoppingList/' . $shoppingList->id);

        $response->assertStatus(204);
        $this->assertNull(ShoppingList::find($shoppingList->id));
    }
    public function testUpdateShoppingListNotFound()
    {
        $shoppingListId = 999;

        $newData = [
            'name' => 'Updated Shopping List Name',
            'description' => 'Updated description of the shopping list'
        ];

        $response = $this->put('/api/shoppingList/' . $shoppingListId, $newData);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Shopping list not found.']);
    }
}


