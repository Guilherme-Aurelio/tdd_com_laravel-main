<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ShoppingList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShoppingListTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateShoppingList()
    {
        $shoppingListData = [
            'name' => 'Test Shopping List',
            'description' => 'Test Description',
        ];
        $shoppingList = ShoppingList::create($shoppingListData);

        $this->assertDatabaseHas('shopping_lists', $shoppingListData);
        $this->assertEmpty($shoppingList->items);
    }
}
