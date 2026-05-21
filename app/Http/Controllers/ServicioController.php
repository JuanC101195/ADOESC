<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicioRequest;
use App\Models\CategoriaServicio;
use App\Models\Proveedor;
use App\Models\Servicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

/**
 * CRUD de servicios (asociados a un proveedor y una categoría).
 */
class ServicioController extends Controller implements HasMiddleware
{
    /** Solo Administrador y Organizador pueden modificar. */
    public static function middleware(): array
    {
        return [
            new Middleware('rol:Administrador,Organizador', except: ['index', 'show']),
        ];
    }

    /** Lista todos los servicios con proveedor y categoría. */
    public function index(): View
    {
        $servicios = Servicio::with('proveedor', 'categoria')->orderBy('nombre')->paginate(10);

        return view('servicios.index', compact('servicios'));
    }

    /** Formulario de creación con selects de proveedor y categoría. */
    public function create(): View
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $categorias = CategoriaServicio::orderBy('nombre')->get();

        return view('servicios.create', compact('proveedores', 'categorias'));
    }

    /** Guarda un nuevo servicio. */
    public function store(ServicioRequest $request): RedirectResponse
    {
        Servicio::create($request->validated());

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    /** Detalle del servicio. */
    public function show(Servicio $servicio): View
    {
        $servicio->load('proveedor', 'categoria', 'reservas.evento');

        return view('servicios.show', compact('servicio'));
    }

    /** Formulario de edición. */
    public function edit(Servicio $servicio): View
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $categorias = CategoriaServicio::orderBy('nombre')->get();

        return view('servicios.edit', compact('servicio', 'proveedores', 'categorias'));
    }

    /** Actualiza el servicio. */
    public function update(ServicioRequest $request, Servicio $servicio): RedirectResponse
    {
        $servicio->update($request->validated());

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    /** Elimina el servicio. */
    public function destroy(Servicio $servicio): RedirectResponse
    {
        if ($servicio->reservas()->exists()) {
            return back()->with('error', 'No se puede eliminar: el servicio tiene reservas asociadas.');
        }

        $servicio->delete();

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}
