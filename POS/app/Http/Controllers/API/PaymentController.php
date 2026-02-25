<?php

namespace App\Http\Controllers\API;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    // عرض جميع المدفوعات (للمدير فقط)
    public function index()
    {
        $payments = Payment::with('order.user')->get();
        return response()->json($payments);
    }

    // عرض دفعة معينة (للمدير أو صاحب الطلب)
    public function show(Payment $payment)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'manager' && $payment->order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($payment->load('order'));
    }

    // معالجة الدفع (إنشاء دفعة وتحديث حالة الطلب)
    public function process(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'methode' => 'required|string|in:carte,espèces,autre',
            'montant' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($request->order_id);

        // تحقق: المستخدم هو صاحب الطلب أو مدير
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'manager' && $order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // تأكد أن الطلب لم يدفع بعد
        if ($order->payment) {
            return response()->json(['message' => 'Cette commande a déjà été payée'], 400);
        }

        // تحقق من المبلغ (يمكن يكون كاملاً أو جزئياً)
        // هنا نفترض أن المبلغ يجب أن يساوي total على الأقل
        if ($request->montant < $order->total) {
            return response()->json(['message' => 'Le montant est insuffisant'], 400);
        }

        // إنشاء الدفع
        $payment = Payment::create([
            'order_id' => $order->id,
            'methode' => $request->methode,
            'montant' => $request->montant,
            'statut' => 'payé',
            'date_paiement' => now(),
        ]);

        // تحديث حالة الطلب إلى 'payé' (إذا كان كامل)
        $order->update(['statut' => 'payé']);

        return response()->json($payment, 201);
    }

    // تحديث الدفع (للمدير فقط)
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'statut' => 'sometimes|string|in:en attente,payé,remboursé,échoué',
        ]);

        $payment->update($request->only('statut'));
        return response()->json($payment);
    }

    // حذف الدفع (للمدير فقط)
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'تم الحذف']);
    }
}