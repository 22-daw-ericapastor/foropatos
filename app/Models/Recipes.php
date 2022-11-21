<?php

namespace Models;

use \Models\BaseModel as model;

class Recipes extends model
{

    private string $table='recetas';

    function get_recipes($recipe = null)
    {
        if (isset($recipe)) {
            // devolver solo esa receta
        } else {
            // devolver todas las recetas
        }
    }
}