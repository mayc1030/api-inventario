<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de productos.
 *
 * Permite listar, crear, mostrar, actualizar y eliminar productos.
 * Cada producto está relacionado con una categoría.
 */
class ProductController extends Controller
{
    /**
     * Muestra un listado paginado de productos con su categoría.
     *
     * @return \Illuminate\Http\JsonResponse JSON con los productos paginados
     */
    public function index()
    {
        $products = Product::with('category')->paginate(10); // Obtiene productos con relación a categoría, paginados de 10 en 10
        return response()->json($products);
    }

    /**
     * Crea un nuevo producto.
     *
     * Valida:
     * - category_id: obligatorio y debe existir en la tabla categories
     * - name: obligatorio, cadena, max 255 caracteres
     * - description: opcional, cadena
     * - price: obligatorio, numérico y mínimo 0
     * - stock: obligatorio, entero y mínimo 0
     *
     * @param Request $request Datos del producto
     * @return \Illuminate\Http\JsonResponse Producto creado con código 201
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    /**
     * Muestra un producto específico por ID con su categoría.
     *
     * Retorna error 404 si no se encuentra el producto.
     *
     * @param string $id ID del producto
     * @return \Illuminate\Http\JsonResponse Producto o mensaje de error
     */
    public function show(string $id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        return response()->json($product);
    }

    /**
     * Actualiza un producto específico.
     *
     * Valida solo los campos presentes (validación condicional "sometimes").
     * Retorna error 404 si no se encuentra el producto.
     *
     * @param Request $request Datos a actualizar
     * @param string $id ID del producto a actualizar
     * @return \Illuminate\Http\JsonResponse Producto actualizado o mensaje de error
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    /**
     * Elimina un producto por ID.
     *
     * Retorna error 404 si no se encuentra el producto.
     *
     * @param string $id ID del producto a eliminar
     * @return \Illuminate\Http\JsonResponse Mensaje confirmando eliminación o error
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Producto eliminado']);
    }
}
