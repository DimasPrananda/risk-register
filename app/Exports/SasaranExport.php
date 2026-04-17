<?php

namespace App\Exports;

use App\Models\Sasaran;
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

class SasaranExport implements FromView, WithStyles, WithColumnWidths, WithEvents
{
    protected $id;

    protected $sasaran;

    protected $mergeData = [];

    public function getMergeData()
    {
        return $this->mergeData;
    }

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
                $currentRow = 3;

                $totalSebab = $this->sasaran->sebabRisikos->count();
                if ($totalSebab > 1) {

                    $totalRows = 0;
                    foreach ($this->sasaran->sebabRisikos as $s) {
                        $totalRows += max(1, $s->perlakuanRisikos->count());
                    }

                    $endRow = 3 + $totalRows - 1;

                    foreach (['A','B','C','D'] as $col) {
                        $sheet->mergeCells("$col"."3:$col$endRow");
                    }
                }

                foreach ($this->sasaran->sebabRisikos as $sebab) {

                    $count = max(1, $sebab->perlakuanRisikos->count());

                    $start = $currentRow;
                    $end = $currentRow + $count - 1;

                    if ($count > 1) {
                        foreach (['E','F','G','H','I','J','K','L','M'] as $col) {
                            $sheet->mergeCells("$col$start:$col$end");
                        }
                    }

                    $currentRow += $count;
                }

                for ($row = 3; $row <= $highestRow; $row++) {
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

        // Vertical center semua
        $sheet->getStyle('A1:Z1000')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Header center (SEMUA KOLOM + 2 BARIS)
        $sheet->getStyle('A1:R2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:R2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // 🔥 WARNA HEADER
        $sheet->getStyle('A1:R2')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF4472C4');

        // 🔥 WARNA TEXT HEADER (biar kontras putih)
        $sheet->getStyle('A1:R2')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        $sheet->getStyle('J1:M1')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        $sheet->getStyle('J1:M1')->getFont()->getColor()->setARGB(Color::COLOR_BLACK);

        $sheet->getStyle('O1')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        $sheet->getStyle('O1')->getFont()->getColor()->setARGB(Color::COLOR_BLACK);

        // Kolom No center
        $sheet->getStyle('A2:A1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Kolom angka & status (center)
        $sheet->getStyle('I3:M1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('O3:R1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Kolom teks
        $sheet->getStyle('B2:H1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('N2:N1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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
            1 => [1 => ['nilai'=>1,'level'=>'Low'], 2 => ['nilai'=>5,'level'=>'Low'], 3 => ['nilai'=>10,'level'=>'Low to Moderate'], 4 => ['nilai'=>15,'level'=>'Moderate'], 5 => ['nilai'=>20,'level'=>'High']],
            2 => [1 => ['nilai'=>2,'level'=>'Low'], 2 => ['nilai'=>6,'level'=>'Low to Moderate'], 3 => ['nilai'=>11,'level'=>'Low to Moderate'], 4 => ['nilai'=>16,'level'=>'Moderate to High'], 5 => ['nilai'=>21,'level'=>'High']],
            3 => [1 => ['nilai'=>3,'level'=>'Low'], 2 => ['nilai'=>8,'level'=>'Low to Moderate'], 3 => ['nilai'=>13,'level'=>'Moderate'], 4 => ['nilai'=>18,'level'=>'Moderate to High'], 5 => ['nilai'=>23,'level'=>'High']],
            4 => [1 => ['nilai'=>4,'level'=>'Low'], 2 => ['nilai'=>9,'level'=>'Low to Moderate'], 3 => ['nilai'=>14,'level'=>'Moderate'], 4 => ['nilai'=>19,'level'=>'Moderate to High'], 5 => ['nilai'=>24,'level'=>'High']],
            5 => [1 => ['nilai'=>7,'level'=>'Low to Moderate'], 2 => ['nilai'=>12,'level'=>'Moderate'], 3 => ['nilai'=>17,'level'=>'Moderate to High'], 4 => ['nilai'=>22,'level'=>'High'], 5 => ['nilai'=>25,'level'=>'High']],
        ];

        $this->sasaran = Sasaran::with([
            'sebabRisikos.perlakuanRisikos'
        ])->findOrFail($this->id);

        $this->sasaran->sebabRisikos->each(function ($item) use ($riskMatrix) {

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

        return view('exports.sasaran-excel', [
            'sasaran' => $this->sasaran
        ]);
    }
}
