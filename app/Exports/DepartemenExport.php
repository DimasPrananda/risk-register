<?php

namespace App\Exports;

use App\Models\Departemen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DepartemenExport implements FromView, WithStyles, WithColumnWidths, WithEvents
{
    protected $id;
    protected $departemen;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                $currentRow = 7;

                foreach ($this->departemen->sasarans as $sasaran) {

                    $totalRows = 0;
                    foreach ($sasaran->sebabRisikos as $s) {
                        $totalRows += max(1, $s->perlakuanRisikos->count());
                    }

                    $startGlobal = $currentRow;
                    $endGlobal   = $currentRow + $totalRows - 1;

                    if ($totalRows > 1) {
                        foreach (['A','B','C','D'] as $col) {
                            $sheet->mergeCells("$col$startGlobal:$col$endGlobal");
                        }
                    }

                    foreach ($sasaran->sebabRisikos as $sebab) {

                        $count = max(1, $sebab->perlakuanRisikos->count());

                        $start = $currentRow;
                        $end   = $currentRow + $count - 1;

                        if ($count > 1) {
                            foreach (['E','F','G','H','I','J','K','L','M'] as $col) {
                                $sheet->mergeCells("$col$start:$col$end");
                            }
                        }

                        $currentRow += $count;
                    }
                }

                for ($row = 7; $row <= $highestRow; $row++) {

                    // INHERENT (M)
                    $level = strtolower(trim($sheet->getCell("M$row")->getValue()));

                    $color = match ($level) {
                        'low' => 'FF00B050',
                        'low to moderate' => 'FF92D050',
                        'moderate' => 'FFFFFF00',
                        'moderate to high' => 'FFFFC000',
                        'high' => 'FFFF0000',
                        default => null,
                    };

                    if ($color) {
                        $sheet->getStyle("M$row")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB($color);
                    }

                    $level2 = strtolower(trim($sheet->getCell("R$row")->getValue()));

                    $color2 = match ($level2) {
                        'low' => 'FF00B050',
                        'low to moderate' => 'FF92D050',
                        'moderate' => 'FFFFFF00',
                        'moderate to high' => 'FFFFC000',
                        'high' => 'FFFF0000',
                        default => null,
                    };

                    if ($color2) {
                        $sheet->getStyle("R$row")->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB($color2);
                    }
                }
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A:Z')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:A3')->getAlignment()->setWrapText(false);

        // vertical center semua
        $sheet->getStyle('A1:Z1000')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // header center
        $sheet->getStyle('A5:R6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:R6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // warna header biru
        $sheet->getStyle('A5:R6')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF4472C4');

        // font putih
        $sheet->getStyle('A5:R6')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        // TR (J-M) kuning
        $sheet->getStyle('J5:M5')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        $sheet->getStyle('J5:M5')->getFont()->getColor()->setARGB(Color::COLOR_BLACK);

        // TR Residual label (O)
        $sheet->getStyle('O5')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        $sheet->getStyle('O5')->getFont()->getColor()->setARGB(Color::COLOR_BLACK);

        // kolom no
        $sheet->getStyle('A5:A1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // angka center
        $sheet->getStyle('I5:M1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('O5:R1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // teks kiri
        $sheet->getStyle('B7:H1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('N7:N1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 25,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 40,
            'H' => 20,
            'I' => 25,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 30,
            'N' => 40,
            'O' => 12,
            'P' => 12,
            'Q' => 12,
            'R' => 30,
        ];
    }

    public function view(): View
    {
        $riskMatrix = [
            1 => [1=>['nilai'=>1,'level'=>'Low'],2=>['nilai'=>5,'level'=>'Low'],3=>['nilai'=>10,'level'=>'Low to Moderate'],4=>['nilai'=>15,'level'=>'Moderate'],5=>['nilai'=>20,'level'=>'High']],
            2 => [1=>['nilai'=>2,'level'=>'Low'],2=>['nilai'=>6,'level'=>'Low to Moderate'],3=>['nilai'=>11,'level'=>'Low to Moderate'],4=>['nilai'=>16,'level'=>'Moderate to High'],5=>['nilai'=>21,'level'=>'High']],
            3 => [1=>['nilai'=>3,'level'=>'Low'],2=>['nilai'=>8,'level'=>'Low to Moderate'],3=>['nilai'=>13,'level'=>'Moderate'],4=>['nilai'=>18,'level'=>'Moderate to High'],5=>['nilai'=>23,'level'=>'High']],
            4 => [1=>['nilai'=>4,'level'=>'Low'],2=>['nilai'=>9,'level'=>'Low to Moderate'],3=>['nilai'=>14,'level'=>'Moderate'],4=>['nilai'=>19,'level'=>'Moderate to High'],5=>['nilai'=>24,'level'=>'High']],
            5 => [1=>['nilai'=>7,'level'=>'Low to Moderate'],2=>['nilai'=>12,'level'=>'Moderate'],3=>['nilai'=>17,'level'=>'Moderate to High'],4=>['nilai'=>22,'level'=>'High'],5=>['nilai'=>25,'level'=>'High']],
        ];

        $this->departemen = Departemen::with([
            'sasarans.sebabRisikos.perlakuanRisikos'
        ])->findOrFail($this->id);

        foreach ($this->departemen->sasarans as $sasaran) {

            $sasaran->sebabRisikos->each(function ($item) use ($riskMatrix) {

                $c = $item->dampak;
                $l = $item->probabilitas;

                if ($c && $l && isset($riskMatrix[$l][$c])) {
                    $item->skala_risiko = $riskMatrix[$l][$c]['nilai'];
                    $item->level_risiko = $riskMatrix[$l][$c]['level'];
                } else {
                    $item->skala_risiko = null;
                    $item->level_risiko = '-';
                }

                $item->perlakuanRisikos->each(function ($perlakuan) use ($riskMatrix) {

                    $c2 = $perlakuan->dampak;
                    $l2 = $perlakuan->probabilitas;

                    if ($c2 && $l2 && isset($riskMatrix[$l2][$c2])) {
                        $perlakuan->skala_risiko = $riskMatrix[$l2][$c2]['nilai'];
                        $perlakuan->level_risiko = $riskMatrix[$l2][$c2]['level'];
                    } else {
                        $perlakuan->skala_risiko = null;
                        $perlakuan->level_risiko = '-';
                    }
                });
            });
        }

        return view('exports.departemen-excel', [
            'departemen' => $this->departemen
        ]);
    }
}