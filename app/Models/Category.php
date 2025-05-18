<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Category
 *
 * Representa una categoría dentro de la aplicación.
 *
 * Importante:
 * - El atributo $fillable protege contra asignación masiva permitiendo solo 'name' y 'description'.
 * - Define una relación uno a muchos con el modelo Product, indicando que una categoría
 *   puede tener múltiples productos asociados.
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden ser asignados masivamente.
     * Esto es importante para la seguridad y evitar vulnerabilidades
     * de asignación masiva.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Relación uno a muchos con el modelo Product.
     * Permite acceder a todos los productos que pertenecen a esta categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

