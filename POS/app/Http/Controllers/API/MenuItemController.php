<?php

namespace App\Http\Controllers\API;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuItemController extends Controller
{
    // عرض جميع العناصر (عام)
    public function index()
    {
        $items = MenuItem::with('category', 'stock')->get();
        return response()->json($items);
    }

    // تخزين عنصر جديد (يتطلب صلاحيات admin/manager)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'availability' => 'boolean'
        ]);

        $item = MenuItem::create($request->all());

        return response()->json($item, 201);
    }

    // عرض عنصر واحد
    public function show(MenuItem $menuItem)
    {
        return response()->json($menuItem->load('category', 'stock'));
    }

    // تحديث عنصر (admin/manager)
    public function update(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'description' => 'nullable|string',
            'availability' => 'boolean'
        ]);

        $menuItem->update($request->all());

        return response()->json($menuItem);
    }

    // حذف عنصر (admin/manager)
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}