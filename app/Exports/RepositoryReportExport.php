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

class RepositoryReportExport implements WithTitle, FromArray, ShouldAutoSize, /*WithColumnFormatting,*/ WithHeadings, WithStrictNullComparison, WithStyles
{
    protected $repositories;
    
    public function __construct(array $repositories)
    {
        $this->repositories = $repositories;
    }

    public function title(): string
    {
        return 'Repositorios';
    }

    public function headings(): array
    {
        return [
            "Nombre del REA",
            "Estatus",
            "Progreso del curso REA",
            "Encargado",
            "Evaluador",
            "Estatus del REA",
            "Estatus de la evaluación",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            'B2:B10000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'C2:C10000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'F2:F10000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'G2:G10000' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]
        ];
    }

    public function array(): array
    {
        return $this->repositories;
    }
}
