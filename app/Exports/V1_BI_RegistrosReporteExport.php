<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

// use Maatwebsite\Excel\Concerns\WithProperties;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;

class V1_BI_RegistrosReporteExport implements FromArray, WithStyles, ShouldAutoSize, WithHeadings, WithDrawings, WithCustomStartCell
{
    protected $data_registros_reportes;
    public function __construct(array $data_registros_reportes)
    {
        $this->data_registros_reportes = $data_registros_reportes;
    }
    public function startCell(): string
    {
        return 'A6'; // Los datos comenzarán en la fila 6
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('img/logo-msb-5.png')); // Asegúrate de tener el logo en esta ruta
        $drawing->setHeight(90);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    /**
     * Devuelve un array de datos para el Excel
     */
    public function array(): array
    {
         $i =1;
        // Aquí seleccionas solo los campos que necesitas para el Excel
        return array_map(function ($item) use (&$i) {
            $item = (array) $item;
            return [
                    $i++,
                    $item['NRO_TRAMITE'].' '.$item['ANO_TRAMITE'],
                    $item['TIPO_DOC'] .'-'. $item['NRO_DOC'].'-'.$item['ANO_DOC'],
                    $item['FECHA_TRAMITE'] ?? '' ,
                    $item['FECHA_RECIBE'] ?? '' ,
                    $item['CTRB_DES'] ?? '' ,
                    $item['AREA_SALIDA_DES'] ?? '' ,
                    $item['AREA_RECIBE_DES'] ?? '' ,
                    $item['MOTIVO_DES'] ?? '' ,
                    $item['SITUAC_ACTUAL'] ?? ''
            ];
        }, $this->data_registros_reportes['data']);
    }
    /**
     * Aplica estilos a las celdas del Excel.
     */
    public function styles(Worksheet $sheet)
    {
        // $sheet->getStyle('A1:AE1')->getFont()->setBold(true);
        // $sheet->getStyle('X2:X' . (count($this->data_registros_reportes) + 1))
        //     ->getNumberFormat()
        //     ->setFormatCode('"S/."#,##0.00;[RED]"S/."-#,##0.00');

        // Título del reporte
        $sheet->mergeCells('A3:k3');
        $sheet->setCellValue('A3', 'REPORTE DE REGISTROS');
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        // Subtítulo o fecha
        $sheet->mergeCells('A4:k4');
        // $sheet->setCellValue('A4', 'Fecha: ' . Carbon::now()->format('d/m/Y'));
        $sheet->setCellValue('A4', 'Fecha: ' . $this->data_registros_reportes['desde'] . ' - ' . $this->data_registros_reportes['hasta']);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
     // Estilos para las cabeceras de la tabla
     $sheet->getStyle('A6:J6')->getFont()->setBold(true);
     $sheet->getStyle('A6:J6')->getFill()
         ->setFillType('solid')
         ->getStartColor()->setRGB('CCCCCC');
    $sheet->getStyle('A6:J6')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('A6:J6')->getAlignment()->setVertical('center');



        // Bordes para toda la tabla
        $lastRow = count($this->data_registros_reportes['data']) + 6;
        $sheet->getStyle('A6:J' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle('thin');

        // // Formato para columnas de montos
        // $sheet->getStyle('X7:X' . $lastRow)
        //     ->getNumberFormat()
        //     ->setFormatCode('"S/."#,##0.00;[RED]"S/."\-#,##0.00');


                // 🔒 Protección de la hoja
    $sheet->getProtection()->setSheet(true);
    $sheet->getProtection()->setSort(true);
    $sheet->getProtection()->setInsertRows(true);
    $sheet->getProtection()->setFormatCells(true);

    // Si quieres poner contraseña
    $sheet->getProtection()->setPassword('msb2024');

    }
    /**
     * Define las cabeceras personalizadas para el Excel
     */
    public function headings(): array
    {
        return [
            'ITEM',
            'TRÁMITE',
            'DOCUMENTO',
            'INGRESO',
            'ULTIMO PASE',
            'ADMINISTRADO',
            'AREA ORIGEN',
            'AREA DESTINO',
            'MOTIVO',
            'ESTADO'
        ];
    }
}
