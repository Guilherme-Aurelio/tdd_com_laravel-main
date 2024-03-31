<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ShoppingList;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ShoppingListControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $response = $this->get('/api/shoppingList');
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $shoppingList = ShoppingList::factory()->create();

        $response = $this->get('/api/shoppingList/' . $shoppingList->id);
        $response->assertStatus(200)
                 ->assertJsonFragment($shoppingList->toArray());
    }

    public function testStore()
    {
        $data = [
            'name' => 'New Shopping List',
            'description' => 'Description of the new shopping list'
        ];
        $response = $this->post('/api/shoppingList', $data);
        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }

    public function testUpdate()
    {
        $shoppingList = ShoppingList::factory()->create();

        $newData = [
            'name' => 'Updated Shopping List Name',
            'description' => 'Updated description of the shopping list'
        ];

        $response = $this->put('/api/shoppingList/' . $shoppingList->id, $newData);
        $response->assertStatus(200)
                 ->assertJsonFragment($newData);
    }

    public function testDestroy()
    {
        $shoppingList = ShoppingList::factory()->create();

        $response = $this->delete('/api/shoppingList/' . $shoppingList->id);
        $response->assertStatus(204);
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
