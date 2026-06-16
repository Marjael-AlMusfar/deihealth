<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $students = Student::query()
            ->when($request->query('search'), fn ($query, $search) => $query->where('name', 'like', "%{$search}%")->orWhere('nis', 'like', "%{$search}%"))
            ->when($request->query('dormitory'), fn ($query, $dormitory) => $query->where('dormitory', $dormitory))
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json($students);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        return response()->json(Student::create($data), 201);
    }

    public function show(Student $student): JsonResponse
    {
        return response()->json($student->load('healthReports'));
    }

    public function update(Request $request, Student $student): JsonResponse
    {
        $data = $request->validate($this->rules($student));
        $student->update($data);

        return response()->json($student->refresh());
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json(status: 204);
    }

    private function rules(?Student $student = null): array
    {
        return [
            'nis' => ['required', 'string', 'max:50', Rule::unique('students', 'nis')->ignore($student)],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'birth_date' => ['nullable', 'date'],
            'class_name' => ['nullable', 'string', 'max:100'],
            'dormitory' => ['nullable', 'string', 'max:100'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_phone' => ['nullable', 'string', 'max:50'],
            'allergies' => ['nullable', 'string'],
            'medical_notes' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
