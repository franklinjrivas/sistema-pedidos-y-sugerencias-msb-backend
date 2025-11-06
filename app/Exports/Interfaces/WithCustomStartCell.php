<?php

namespace App\Exports;

interface WithCustomStartCell
{
    /**
     * Define la celda inicial donde comenzará el contenido del Excel.
     * @return string Ejemplo: 'A1', 'B2', etc.
     */
    public function startCell(): string;
}
