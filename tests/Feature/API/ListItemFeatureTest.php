<?php // tests/Feature/ListItemFeatureTest.php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShoppingList;
use App\Models\ListItem;

class ListItemFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_items()
    {
        $shoppingList = ShoppingList::factory()->create();
        $items = ListItem::factory()->count(3)->create(['shopping_list_id' => $shoppingList->id]);

        $response = $this->get('/api/shoppingList/' . $shoppingList->id . '/items');

        $response->assertStatus(200)
                 ->assertJson($items->toArray());
    }

    public function test_can_show_item()
    {
        $shoppingList = ShoppingList::factory()->create();
        $item = ListItem::factory()->create(['shopping_list_id' => $shoppingList->id]);

        $response = $this->get('/api/shoppingList/' . $shoppingList->id . '/items/' . $item->id);

        $response->assertStatus(200)
                 ->assertJson($item->toArray());
    }

    public function test_can_store_item()
    {
        $shoppingList = ShoppingList::factory()->create();
        $data = [
            'name' => 'Test Item',
            'quantity' => 5,
            'completed' => false,
        ];

        $response = $this->post('/api/shoppingList/' . $shoppingList->id . '/items', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);
    }

    public function test_can_update_item()
    {
        $shoppingList = ShoppingList::factory()->create();
        $item = ListItem::factory()->create(['shopping_list_id' => $shoppingList->id]);
        $updateData = [
            'name' => 'Updated Name',
            'quantity' => 10,
        ];

        $response = $this->put('/api/shoppingList/' . $shoppingList->id . '/items/' . $item->id, $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updateData);
    }

    public function test_can_delete_item()
    {
        $shoppingList = ShoppingList::factory()->create();
        $item = ListItem::factory()->create(['shopping_list_id' => $shoppingList->id]);

        $response = $this->delete('/api/shoppingList/' . $shoppingList->id . '/items/' . $item->id);

        $response->assertStatus(204);
        $this->assertNull(ListItem::find($item->id));
    }
    public function testShowItemNotFound()
    {
        $itemId = 999; 
        $shoppingListId = 1;

        $response = $this->get("/api/shoppingList/{$shoppingListId}/items/{$itemId}");

        $response->assertStatus(404)
                 ->assertJson(['message' => 'List item not found.']);
    }

    public function testDestroyItemNotFound()
    {
        $itemId = 999;
        $shoppingListId = 1;

        $response = $this->delete("/api/shoppingList/{$shoppingListId}/items/{$itemId}");

        $response->assertStatus(404)
                 ->assertJson(['message' => 'List item not found.']);
    }
    public function testUpdateListItemNotFound()
    {
        $shoppingListId = 999;
        $itemId = 999;

        $updateData = [
            'name' => 'Updated Name',
            'quantity' => 10,
        ];

        $response = $this->put("/api/shoppingList/{$itemId}/items/{$shoppingListId}", $updateData);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'List item not found.']);
    }
}
