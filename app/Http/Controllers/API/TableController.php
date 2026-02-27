<?php

namespace App\Http\Controllers\API;

use App\Models\TableResto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableController extends Controller
{
    // عرض جميع الطاولات (للمدير والمدير)
    public function index()
    {
        $tables = TableResto::all();
        return response()->json($tables);
    }

    // إضافة طاولة جديدة (admin/manager)
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer|unique:table_restos',
            'capacite' => 'required|integer|min:1',
            'statut' => 'sometimes|string|in:libre,occupée,réservée',
        ]);

        $table = TableResto::create($request->all());
        return response()->json($table, 201);
    }

    // عرض طاولة واحدة
    public function show(TableResto $tableResto)
    {
        return response()->json($tableResto->load('reservations'));
    }

    // تحديث طاولة (admin/manager)
    public function update(Request $request, TableResto $tableResto)
    {
        $request->validate([
            'numero' => 'sometimes|integer|unique:table_restos,numero,' . $tableResto->id,
            'capacite' => 'sometimes|integer|min:1',
            'statut' => 'sometimes|string|in:libre,occupée,réservée',
        ]);

        $tableResto->update($request->all());
        return response()->json($tableResto);
    }

    // حذف طاولة (admin/manager)
    public function destroy(TableResto $tableResto)
    {
        $tableResto->delete();
        return response()->json(['message' => 'تم الحذف']);
    }

    // ✨ ميثود إضافية: جلب الطاولات المتاحة (للواجهة)
    public function available(Request $request)
    {
        $request->validate([
            'date' => 'sometimes|date',
            'heure' => 'sometimes|date_format:H:i',
            'personnes' => 'sometimes|integer|min:1',
        ]);

        // مثال بسيط: جلب الطاولات الفارغة (statut = libre)
        $query = TableResto::where('statut', 'libre');

        // إذا حدد عدد الأشخاص، نضيف شرط capacity
        if ($request->has('personnes')) {
            $query->where('capacite', '>=', $request->personnes);
        }

        $tables = $query->get();

        return response()->json($tables);
    }
}