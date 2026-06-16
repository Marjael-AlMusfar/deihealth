<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineStockMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MedicineController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $medicines = Medicine::query()
            ->when($request->query('search'), fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($request->boolean('low_stock'), fn ($query) => $query->whereColumn('current_stock', '<=', 'minimum_stock'))
            ->orderBy('name')
            ->paginate($request->integer('per_page', 15));

        return response()->json($medicines);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        return response()->json(Medicine::create($data), 201);
    }

    public function show(Medicine $medicine): JsonResponse
    {
        return response()->json($medicine->load('stockMovements'));
    }

    public function update(Request $request, Medicine $medicine): JsonResponse
    {
        $data = $request->validate($this->rules(false));
        $medicine->update($data);

        return response()->json($medicine->refresh());
    }

    public function destroy(Medicine $medicine): JsonResponse
    {
        $medicine->delete();

        return response()->json(status: 204);
    }

    public function moveStock(Request $request, Medicine $medicine): JsonResponse
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['masuk', 'keluar', 'koreksi'])],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $movement = DB::transaction(function () use ($medicine, $data): MedicineStockMovement {
            $quantity = $data['type'] === 'keluar' ? -$data['quantity'] : $data['quantity'];
            $medicine->increment('current_stock', $quantity);

            return $medicine->stockMovements()->create($data + ['moved_at' => now()]);
        });

        return response()->json($movement->load('medicine'), 201);
    }

    private function rules(bool $creating = true): array
    {
        return [
            'name' => [$creating ? 'required' : 'sometimes', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'unit' => [$creating ? 'required' : 'sometimes', 'string', 'max:50'],
            'default_dose' => ['nullable', 'string', 'max:100'],
            'indication' => ['nullable', 'string'],
            'contraindication' => ['nullable', 'string'],
            'minimum_stock' => ['sometimes', 'integer', 'min:0'],
            'current_stock' => ['sometimes', 'integer', 'min:0'],
            'expires_at' => ['nullable', 'date'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
