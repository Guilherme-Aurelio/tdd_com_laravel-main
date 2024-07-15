<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListItem;

class ListItemController extends Controller
{
    public function __construct(private ListItem $listItem)
    {

    }

    public function index($shoppingListId)
    {
        $items = $this->listItem->where('shopping_list_id', $shoppingListId)->get();
        return response()->json($items);
    }

    public function show($shoppingListId, $id)
    {
        $item = $this->listItem->where('shopping_list_id', $shoppingListId)->find($id);

        if (!$item) {
            return response()->json(['message' => 'List item not found.'], 404);
        }

        return response()->json($item);
    }

    public function store(Request $request, $shoppingListId)
    {
        $data = $request->all();
        $data['shopping_list_id'] = $shoppingListId;
        $item = $this->listItem->create($data);
        return response()->json($item, 201);
    }

    public function update(Request $request, $shoppingListId, $id)
    {
        $item = $this->listItem->where('shopping_list_id', $shoppingListId)->find($id);

        if (!$item) {
            return response()->json(['message' => 'List item not found.'], 404);
        }

        $item->update($request->all());

        return response()->json($item, 200);
    }

    public function destroy($shoppingListId, $id)
    {
        $item = $this->listItem->where('shopping_list_id', $shoppingListId)->find($id);

        if (!$item) {
            return response()->json(['message' => 'List item not found.'], 404);
        }

        $item->delete();

        return response()->json([], 204);
    }
}
