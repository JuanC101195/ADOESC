<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaServicioRequest;
use App\Models\CategoriaServicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

/**
 * CRUD de categorías de servicio.
 */
class CategoriaServicioController extends Controller implements HasMiddleware
{
    /** Solo Administrador y Organizador pueden modificar. */
    public static function middleware(): array
    {
        return [
            new Middleware('rol:Administrador,Organizador', except: ['index', 'show']),
        ];
    }

    /** Lista todas las categorías. */
    public function index(): View
    {
        $categorias = CategoriaServicio::withCount('servicios')->orderBy('nombre')->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    /** Formulario de creación. */
    public function create(): View
    {
        return view('categorias.create');
    }

    /** Guarda una nueva categoría. */
    public function store(CategoriaServicioRequest $request): RedirectResponse
    {
        CategoriaServicio::create($request->validated());

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /** Detalle de la categoría con sus servicios. */
    public function show(CategoriaServicio $categoria): View
    {
        $categoria->load('servicios.proveedor');

        return view('categorias.show', compact('categoria'));
    }

    /** Formulario de edición. */
    public function edit(CategoriaServicio $categoria): View
    {
        return view('categorias.edit', compact('categoria'));
    }

    /** Actualiza la categoría. */
    public function update(CategoriaServicioRequest $request, CategoriaServicio $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    /** Elimina la categoría. */
    public function destroy(CategoriaServicio $categoria): RedirectResponse
    {
        // Evitamos borrar categorías con servicios asociados.
        if ($categoria->servicios()->exists()) {
            return back()->with('error', 'No se puede eliminar: la categoría tiene servicios asociados.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
