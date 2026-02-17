<?php

namespace App\Http\Controllers;

use App\Models\Concierto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConciertoController extends Controller
{
     /**
     * Mostrar lista de todos los conciertos
     */
    public function index()
    {
        $conciertos = Concierto::orderBy('fecha_evento', 'desc')->paginate(10);
        
        return view('conciertos-crud.index', compact('conciertos'));
    }

    /**
     * Mostrar formulario para crear nuevo concierto
     */
    public function create()
    {
        return view('conciertos-crud.create');
    }

    /**
     * Guardar nuevo concierto en BD
     */
    public function store(Request $request)
    {
        try {
            // Validaciones con REGEX
            $validated = $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'min:3',
                    'max:200'
                ],
                'artista' => [
                    'required',
                    'string',
                    'min:3',
                    'max:200'
                ],
                'descripcion' => [
                    'nullable',
                    'string',
                    'max:1000'
                ],
                'ubicacion' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255'
                ],
                'fecha_evento' => [
                    'required',
                    'date',
                    'after:today'
                ],
                'precio' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:999999.99'
                ],
                'capacidad_total' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:100000'
                ],
                'status' => [
                    'required',
                    'in:activo,cancelado,agotado'
                ],
                'imagen_url' => [
                    'nullable',
                    'url'
                ]
            ], [
                'nombre.required' => 'El nombre del concierto es obligatorio',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'artista.required' => 'El nombre del artista es obligatorio',
                'ubicacion.required' => 'La ubicación es obligatoria',
                'fecha_evento.required' => 'La fecha del evento es obligatoria',
                'fecha_evento.after' => 'La fecha debe ser posterior a hoy',
                'precio.required' => 'El precio es obligatorio',
                'precio.numeric' => 'El precio debe ser un número',
                'capacidad_total.required' => 'La capacidad es obligatoria',
                'capacidad_total.integer' => 'La capacidad debe ser un número entero',
                'status.required' => 'El status es obligatorio',
                'status.in' => 'El status debe ser: activo, cancelado o agotado',
            ]);

            // Boletos disponibles = capacidad total al crear
            $validated['boletos_disponibles'] = $validated['capacidad_total'];

            // Crear en base de datos
            $concierto = Concierto::create($validated);

            Log::info('Concierto creado', [
                'id' => $concierto->id,
                'nombre' => $concierto->nombre
            ]);

            return redirect()
                ->route('conciertos-crud.index')
                ->with('success', "✓ Concierto '{$concierto->nombre}' creado exitosamente.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error creando concierto', [
                'error' => $e->getMessage()
            ]);
            
            return back()
                ->with('error', '❌ Error al crear el concierto. Intenta de nuevo.')
                ->withInput();
        }
    }

    /**
     * Mostrar un concierto específico
     */
    public function show($id)
    {
        $concierto = Concierto::findOrFail($id);
        
        return view('conciertos-crud.show', compact('concierto'));
    }

    /**
     * Mostrar formulario para editar concierto
     */
    public function edit($id)
    {
        $concierto = Concierto::findOrFail($id);
        
        return view('conciertos-crud.edit', compact('concierto'));
    }

    /**
     * Actualizar concierto en BD
     */
    public function update(Request $request, $id)
    {
        try {
            $concierto = Concierto::findOrFail($id);

            // Validaciones
            $validated = $request->validate([
                'nombre' => 'required|string|min:3|max:200',
                'artista' => 'required|string|min:3|max:200',
                'descripcion' => 'nullable|string|max:1000',
                'ubicacion' => 'required|string|min:5|max:255',
                'fecha_evento' => 'required|date',
                'precio' => 'required|numeric|min:0',
                'capacidad_total' => 'required|integer|min:1',
                'boletos_disponibles' => 'required|integer|min:0',
                'status' => 'required|in:activo,cancelado,agotado',
                'imagen_url' => 'nullable|url'
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'artista.required' => 'El artista es obligatorio',
                'ubicacion.required' => 'La ubicación es obligatoria',
                'fecha_evento.required' => 'La fecha es obligatoria',
                'precio.required' => 'El precio es obligatorio',
                'capacidad_total.required' => 'La capacidad es obligatoria',
                'boletos_disponibles.required' => 'Los boletos disponibles son obligatorios',
                'status.required' => 'El status es obligatorio',
            ]);

            // Actualizar
            $concierto->update($validated);

            Log::info('Concierto actualizado', [
                'id' => $concierto->id,
                'nombre' => $concierto->nombre
            ]);

            return redirect()
                ->route('conciertos-crud.index')
                ->with('success', "✓ Concierto '{$concierto->nombre}' actualizado exitosamente.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error actualizando concierto', [
                'error' => $e->getMessage()
            ]);
            
            return back()
                ->with('error', '❌ Error al actualizar. Intenta de nuevo.')
                ->withInput();
        }
    }

    /**
     * Eliminar concierto de BD
     */
    public function destroy($id)
    {
        try {
            $concierto = Concierto::findOrFail($id);
            $nombre = $concierto->nombre;
            
            $concierto->delete();

            Log::info('Concierto eliminado', [
                'id' => $id,
                'nombre' => $nombre
            ]);

            return redirect()
                ->route('conciertos-crud.index')
                ->with('success', "✓ Concierto '{$nombre}' eliminado exitosamente.");

        } catch (\Exception $e) {
            Log::error('Error eliminando concierto', [
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', '❌ Error al eliminar. Intenta de nuevo.');
        }
    }
}