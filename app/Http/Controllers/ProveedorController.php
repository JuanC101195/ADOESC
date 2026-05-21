<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

/**
 * CRUD de proveedores.
 */
class ProveedorController extends Controller implements HasMiddleware
{
    /** Solo Administrador y Organizador pueden modificar. */
    public static function middleware(): array
    {
        return [
            new Middleware('rol:Administrador,Organizador', except: ['index', 'show']),
        ];
    }

    /** Lista todos los proveedores. */
    public function index(): View
    {
        $proveedores = Proveedor::withCount('servicios')->orderBy('nombre')->paginate(10);

        return view('proveedores.index', compact('proveedores'));
    }

    /** Formulario de creación. */
    public function create(): View
    {
        return view('proveedores.create');
    }

    /** Guarda un nuevo proveedor. */
    public function store(ProveedorRequest $request): RedirectResponse
    {
        Proveedor::create($request->validated());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    /** Detalle del proveedor con sus servicios. */
    public function show(Proveedor $proveedor): View
    {
        $proveedor->load('servicios.categoria');

        return view('proveedores.show', compact('proveedor'));
    }

    /** Formulario de edición. */
    public function edit(Proveedor $proveedor): View
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    /** Actualiza el proveedor. */
    public function update(ProveedorRequest $request, Proveedor $proveedor): RedirectResponse
    {
        $proveedor->update($request->validated());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /** Elimina el proveedor. */
    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        if ($proveedor->servicios()->exists()) {
            return back()->with('error', 'No se puede eliminar: el proveedor tiene servicios asociados.');
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
