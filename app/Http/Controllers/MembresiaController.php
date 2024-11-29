<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MembresiaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MembresiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $membresias = Membresia::paginate();

        return view('membresia.index', compact('membresias'))
            ->with('i', ($request->input('page', 1) - 1) * $membresias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $membresia = new Membresia();
        return view('membresia.create', compact('membresia'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tipo' => 'required|string|max:255|unique:membresias',
            'descripcion' => 'required|string',
            'costo' => 'required|numeric|min:0',
            'duracion' => 'required|integer|min:1'
        ]);

        try {
            Membresia::create($request->all());
            return redirect()->route('membresias.index')
                ->with('success', 'Membresía creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la membresía.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $membresia = Membresia::find($id);

        return view('membresia.show', compact('membresia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $membresia = Membresia::find($id);

        return view('membresia.edit', compact('membresia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MembresiaRequest $request, Membresia $membresia): RedirectResponse
    {
        $membresia->update($request->validated());

        return Redirect::route('membresias.index')
            ->with('success', 'Membresia updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Membresia::find($id)->delete();

        return Redirect::route('membresias.index')
            ->with('success', 'Membresia deleted successfully');
    }
}
