<?php

namespace App\Http\Controllers\API;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    // عرض جميع المخزون (للمدير والمدير)
    public function index()
    {
        $stocks = Stock::with('menuItem')->get();
        return response()->json($stocks);
    }

    // عرض عنصر مخزون واحد
    public function show(Stock $stock)
    {
        return response()->json($stock->load('menuItem'));
    }

    // إضافة مخزون جديد (admin/manager)
    public function store(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id|unique:stocks,menu_item_id',
            'quantite' => 'required|integer|min:0',
        ]);

        $stock = Stock::create($request->all());
        return response()->json($stock, 201);
    }

    // تحديث المخزون (admin/manager)
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'quantite' => 'sometimes|integer|min:0',
        ]);

        $stock->update($request->all());
        return response()->json($stock);
    }

    // حذف المخزون (admin/manager)
    public function destroy(Stock $stock)
    {
        $stock->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}