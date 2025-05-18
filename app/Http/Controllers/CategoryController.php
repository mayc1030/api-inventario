<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de categorías.
 *
 * Proporciona métodos para listar, crear, mostrar, actualizar y eliminar categorías.
 */
class CategoryController extends Controller
{
    /**
     * Muestra todas las categorías.
     *
     * @return \Illuminate\Http\JsonResponse Devuelve un JSON con todas las categorías.
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Crea una nueva categoría.
     *
     * Valida que el nombre esté presente y sea una cadena con máximo 255 caracteres.
     * Luego crea la categoría y devuelve el objeto creado con código HTTP 201.
     *
     * @param Request $request Datos de la categoría (name)
     * @return \Illuminate\Http\JsonResponse Categoría creada
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    /**
     * Muestra una categoría específica por su ID.
     *
     * Retorna un error 404 si no existe la categoría.
     *
     * @param string $id ID de la categoría
     * @return \Illuminate\Http\JsonResponse Categoría encontrada o mensaje de error
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($category);
    }

    /**
     * Actualiza una categoría específica.
     *
     * Valida que el nombre esté presente y sea válido.
     * Retorna error 404 si no se encuentra la categoría.
     *
     * @param Request $request Datos para actualizar (name)
     * @param string $id ID de la categoría a actualizar
     * @return \Illuminate\Http\JsonResponse Categoría actualizada o mensaje de error
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return response()->json($category);
    }

    /**
     * Elimina una categoría por su ID.
     *
     * Retorna error 404 si la categoría no existe.
     *
     * @param string $id ID de la categoría a eliminar
     * @return \Illuminate\Http\JsonResponse Mensaje confirmando eliminación o error
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Categoría eliminada']);
    }
}
