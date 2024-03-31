<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListItem;

class ListItemController extends Controller
{
    public function __construct(private ListItem $listItem)
    {

    }

    public function index(Request $request)
    {
        $items = $this->listItem->where('shopping_list_id', $request->input('shopping_list_id'))->get();
        return response()->json($items);
    }

    public function show($id)
    {
        $item = $this->listItem->find($id);

        if (!$item) {
            return response()->json(['message' => 'List item not found.'], 404);
        }

        return response()->json($item);
    }

    public function store(Request $request)
    {
        $item = $this->listItem->create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $itemId)
    {
        $item = $this->listItem->find($itemId);
        if (!$item) {
            // Adicionando log para verificar se o item foi encontrado
            \Log::error('Item not found with ID: ' . $itemId);
            return response()->json(['message' => 'List item not found.'], 404);
        }

        $item->update($request->all());

        return response()->json($item, 200);
    }

    public function destroy($shoppingListId, $itemId)
    {
        $item = $this->listItem->find($itemId);

        if (!$item) {
            return response()->json(['message' => 'List item not found for ID ' . $itemId . ' in shopping list with ID ' . $shoppingListId], 404);
        }

        $item->delete();

        return response()->json([], 204);
    }
}
