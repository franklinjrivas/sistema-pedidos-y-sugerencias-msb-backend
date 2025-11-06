<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

interface WithDrawings
{
    /**
     * Agrega dibujos (imágenes, logos) al Excel.
     * @return Drawing|array Retorna un objeto Drawing o un array de objetos Drawing
     */
    public function drawings();
}
