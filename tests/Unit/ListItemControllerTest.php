<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ShoppingList;
use App\Models\ListItem;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Http\Request;
use App\Http\Controllers\ListItemController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
class ListItemControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $items = ListItem::where('shopping_list_id', 1)->get();
        $response = $this->get('/api/shoppingList/items?shopping_list_id=1');
        $response->assertStatus(200)
                 ->assertJson($items->toArray());
    }
    public function testShowItem()
    {
        $shoppingList = ShoppingList::factory()->create();
        $item = ListItem::factory()->create(['shopping_list_id' => $shoppingList->id]);

        $response = $this->get('/api/shoppingList/' . $item->id . '/items/' . $shoppingList->id);

        $response->assertStatus(200)
                 ->assertJson($item->toArray());
    }
    public function testShow()
    {
        $response = $this->get('/api/shoppingList/1/items');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $shoppingList = ShoppingList::factory()->create();
        $data = [
            'name' => 'Test Item',
            'quantity' => 5,
            'completed' => false,
            'shopping_list_id' => $shoppingList->id,
        ];
        $response = $this->post('/api/shoppingList/' . $shoppingList->id . '/items', $data);
        $response->assertStatus(201);
    }


    public function testUpdateListItem()
    {
        $shoppingListId = 98;
        $itemId = 30;

        $updateData = [
            'name' => 'Updated Name',
            'quantity' => 10,
        ];

        $item = ListItem::find($itemId);

        if (!$item) {
            Log::error('Item not found with ID: ' . $itemId);
            $this->fail('Item not found with ID: ' . $itemId);
        }

        $response = $this->put("/api/shoppingList/{$itemId}/items/{$shoppingListId}", $updateData);

        $response->assertStatus(200);

        $response->assertJsonFragment($updateData);

        $updatedItem = ListItem::find($itemId);

        $this->assertEquals($updateData['name'], $updatedItem->name);
        $this->assertEquals($updateData['quantity'], $updatedItem->quantity);
    }

    public function testDestroy()
    {
        $shoppingListId = 98;
        $itemId = 30;

        $url = "/api/shoppingList/{$shoppingListId}/items/{$itemId}";
        $response = $this->delete($url);

        $response->assertStatus(204);

        $this->assertNull(ListItem::find($itemId));
    }
    public function testUpdateItemNotFound() {
        $shoppingListId = 999;
        $itemId = 999;

        $url = "/api/shoppingList/{$shoppingListId}/items/{$itemId}";

        $response = $this->put($url, []);
        $response->assertStatus(404);
        $response->assertJson(['message' => 'List item not found.']);
    }

    public function testDestroyListNotFound()
    {
        $shoppingListId = 999;
        $itemId = 999;
        $url = "/api/shoppingList/{$shoppingListId}/items/{$itemId}";

        $response = $this->delete($url);
        $response->assertStatus(404);
        $response->assertJson(['message' => 'List item not found for ID ' . $itemId . ' in shopping list with ID ' . $shoppingListId]);
    }

    public function testShowItemNotFound()
{
    $itemId = 999;
    
    $response = $this->get('/api/shoppingList/999/items/' . $itemId);
    $response->assertStatus(404);
}

}
