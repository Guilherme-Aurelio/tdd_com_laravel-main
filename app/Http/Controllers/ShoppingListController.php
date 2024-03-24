<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    public function __construct(private ShoppingList $shoppingList)
    {

    }

    public function index()
    {
        return response()->json($this->shoppingList->all());
    }

    public function show($id)
    {
        $shoppingList = $this->shoppingList->find($id);
        return response()->json($shoppingList);
    }

    public function store(Request $request)
    {
        $shoppingList = $this->shoppingList->create($request->all());
        return response()->json($shoppingList, 201);
    }

    public function update(Request $request, $id)
    {
        $shoppingList = $this->shoppingList->find($id);

        if (!$shoppingList) {
            return response()->json(['message' => 'Shopping list not found.'], 404);
        }

        $shoppingList->update($request->all());

        return response()->json($shoppingList, 200);
    }

    public function destroy($id)
    {
        $shoppingList =$this->shoppingList->find($id);
        $shoppingList->delete();

        return response()->json([], 204);
    }
}
