<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(): View
    {
        $faculties = Faculty::latest()->paginate(10);
        return view('admin-fakultas.faculties.index', compact('faculties'));
    }

    public function create(): View
    {
        return view('admin-fakultas.faculties.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:faculties',
            'name' => 'required|string|max:255',
        ]);

        Faculty::create($validated);

        return redirect()->route('faculties.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Faculty $faculty): View
    {
        return view('admin-fakultas.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:faculties,code,' . $faculty->id,
            'name' => 'required|string|max:255',
        ]);

        $faculty->update($validated);

        return redirect()->route('faculties.index')->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Faculty $faculty): RedirectResponse
    {
        $faculty->delete();
        return redirect()->route('faculties.index')->with('success', 'Fakultas berhasil dihapus.');
    }
}
