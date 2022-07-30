<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;


class ReaCourseReportExport implements WithTitle, FromArray, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithStrictNullComparison, WithStyles
{
    protected $teachers;

    public function __construct(array $teachers)
    {
        $this->teachers = $teachers;
    }

    public function title(): string
    {
        return 'Curso REA';
    }

    public function headings(): array
    {
        return [
            "Identificador",
            "Nombre",
            "Unidad académica",
            "Cuestionarios terminados",
            "Porcentaje cuestionarios",
            "Tareas cargadas",
            "Porcentaje tareas",
            "Estatus",
            "Inicio",
            "Fin"
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            'D2:D1000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]],
            'E2:E1000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]],
            'F2:F1000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]],
            'G2:G1000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]],
            'H2:H1000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]
        ];
    }

    public function array(): array
    {
        return $this->teachers;
    }
}
