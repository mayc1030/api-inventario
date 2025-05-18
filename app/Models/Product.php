<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Product
 *
 * Representa un producto dentro del sistema.
 *
 * Importante:
 * - El atributo $fillable protege contra asignación masiva permitiendo solo
 *   los campos definidos: 'category_id', 'name', 'description', 'price', 'stock'.
 * - Define una relación inversa con el modelo Category, indicando que un producto
 *   pertenece a una única categoría.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar masivamente.
     * Protege la integridad del modelo evitando asignación no autorizada.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
    ];

    /**
     * Relación inversa con Category.
     * Permite acceder a la categoría a la que pertenece este producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
