<?php

namespace App\Http\Controllers;

use App\Models\RencanaMenu;
use App\Models\PaketMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RencanaMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = RencanaMenu::with(['paketMenu.menus.bahanBakus'])
            ->orderBy('created_at', 'desc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
        }

        $rencanaMenus = $query->get();

        return view('rencana-menu.index', compact('rencanaMenus'));
    }

    public function show($id)
    {
        $rencana = RencanaMenu::with(['paketMenu.menus.bahanBakus'])->findOrFail($id);
        return $rencana?->toArray();
        // $title = 'Detail Perencanaan Menu';
        // return view('rencana-menu.show', compact('rencana', 'title'));
    }

    public function create()
    {
        $paketmenus = PaketMenu::orderBy('nama')->get(['id', 'nama']);
        $title = 'Formulir Perencanaan Menu';
        return view('rencana-menu.create', compact('paketmenus', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.paket_menu_id' => 'required|exists:paket_menus,id',
            'items.*.porsi' => 'required|numeric|min:1',
        ]);

        //TODO hanya input start_date
        // Parse the periode to extract start_date and end_date
        $periodeParts = explode(' to ', $request->periode);
        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($periodeParts[0]))->format('Y-m-d');
        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($periodeParts[1]))->format('Y-m-d');

        DB::beginTransaction();
        try {
            $rencana = RencanaMenu::create([
                'periode' => $request->periode,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            foreach ($request->items as $item) {
                $rencana->paketMenu()->attach($item['paket_menu_id'], [
                    'porsi' => $item['porsi'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Rencana menu berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
