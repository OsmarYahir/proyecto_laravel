<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImagenesController extends Controller
{
    public function index()
    {
        $imagenes = Imagen::where('activo', true)
            ->orderBy('orden', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('imagenes.index', compact('imagenes'));
    }

    public function store(Request $request)
    {
        try {
            // Validar imagen
            $validated = $request->validate([
                'imagen' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,gif',
                    'max:5120' // 5MB máximo
                ],
                'titulo' => [
                    'nullable',
                    'string',
                    'max:255'
                ]
            ], [
                'imagen.required' => 'Debes seleccionar una imagen',
                'imagen.image' => 'El archivo debe ser una imagen',
                'imagen.mimes' => 'Solo se permiten imágenes JPG, JPEG, PNG o GIF',
                'imagen.max' => 'La imagen no puede ser mayor a 5MB',
                'titulo.max' => 'El título no puede exceder 255 caracteres'
            ]);

            $file = $request->file('imagen');
            
            // Generar nombre único
            $nombreOriginal = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nombreUnico = Str::random(40) . '.' . $extension;
            
            // Guardar en storage/app/public/imagenes
            $ruta = $file->storeAs('imagenes', $nombreUnico, 'public');
            
            // Obtener el siguiente número de orden
            $maxOrden = Imagen::max('orden') ?? 0;
            
            // Guardar en BD
            Imagen::create([
                'titulo' => $validated['titulo'] ?? $nombreOriginal,
                'ruta' => $ruta,
                'nombre_original' => $nombreOriginal,
                'orden' => $maxOrden + 1,
                'activo' => true
            ]);

            Log::info('Imagen subida', [
                'nombre' => $nombreOriginal,
                'ruta' => $ruta
            ]);

            return redirect()
                ->route('imagenes.index')
                ->with('success', 'Imagen subida correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error subiendo imagen', [
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Error al subir la imagen. Intenta de nuevo.');
        }
    }

    public function destroy($id)
    {
        try {
            $imagen = Imagen::findOrFail($id);
            
            // Eliminar archivo físico
            if (Storage::disk('public')->exists($imagen->ruta)) {
                Storage::disk('public')->delete($imagen->ruta);
            }
            
            // Eliminar de BD
            $imagen->delete();
            
            Log::info('Imagen eliminada', [
                'id' => $id,
                'nombre' => $imagen->nombre_original
            ]);
            
            return redirect()
                ->route('imagenes.index')
                ->with('success', 'Imagen eliminada correctamente');
                
        } catch (\Exception $e) {
            Log::error('Error eliminando imagen', [
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Error al eliminar la imagen.');
        }
    }
}