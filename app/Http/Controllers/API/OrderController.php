<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // للمدير فقط: عرض جميع الطلبات
    public function index()
    {
        $orders = Order::with('user', 'orderItems.menuItem', 'payment')->get();
        return response()->json($orders);
    }

    // للمستخدم الحالي: طلباته الخاصة
    public function userOrders(Request $request)
    {
        $orders = $request->user()->orders()->with('orderItems.menuItem')->get();
        return response()->json($orders);
    }

    // إنشاء طلب جديد (للمستخدم)
    public function store(Request $request)
    {
        $request->validate([
            'type_commande' => 'required|string|in:sur place,à emporter,livraison',
            'items' => 'required|array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantite' => 'required|integer|min:1',
        ]);

        // حساب المجموع وإنشاء الطلب
        $total = 0;
        $order = $request->user()->orders()->create([
            'type_commande' => $request->type_commande,
            'statut' => 'en attente',
            'total' => 0, // سنحدثه بعد حساب العناصر
        ]);

        foreach ($request->items as $itemData) {
            $menuItem = \App\Models\MenuItem::find($itemData['menu_item_id']);
            $prix = $menuItem->price;
            $quantite = $itemData['quantite'];
            $order->orderItems()->create([
                'menu_item_id' => $menuItem->id,
                'quantite' => $quantite,
                'prix' => $prix,
            ]);
            $total += $prix * $quantite;
        }

        $order->update(['total' => $total]);

        return response()->json($order->load('orderItems'), 201);
    }

    // عرض طلب معين (للمستخدم صاحب الطلب أو المدير)
    public function show(Order $order)
    {
        // التحقق: المستخدم هو صاحب الطلب أو مدير
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'manager' && $order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($order->load('user', 'orderItems.menuItem', 'payment'));
    }

    // تحديث الطلب (مثلاً تغيير الحالة، للمدير)
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'statut' => 'sometimes|string|in:en attente,confirmé,préparé,livré,payé,annulé',
        ]);

        $order->update($request->only('statut'));

        return response()->json($order);
    }

    // حذف طلب (للمدير فقط)
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}