<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ListItem;
use App\Models\ShoppingList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use App\Providers\BroadcastServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\TrustHosts;
class ListItemTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateListItem()
    {
        $shoppingList = ShoppingList::factory()->create();

        $itemData = [
            'name' => 'Test Item',
            'quantity' => 5,
            'completed' => false,
            'shopping_list_id' => $shoppingList->id,
        ];

        $item = ListItem::create($itemData);

        $this->assertDatabaseHas('list_items', $itemData);
        $this->assertInstanceOf(ShoppingList::class, $item->shoppingList);
        $this->assertEquals($shoppingList->id, $item->shoppingList->id);
    }

}
