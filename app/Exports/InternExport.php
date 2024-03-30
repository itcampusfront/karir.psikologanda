<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;

class InternExport implements FromCollection, WithEvents, WithHeadings,WithMapping
{

    public function __construct($internships)
    {
        $this->internships = $internships;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->internships;
    }

    public function map($intern): array{

        return [
            $intern->name,
            $intern->email,
            $intern->username,
            $intern->attribute->phone_number,
            $intern->attribute->address,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(23);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
            },
        ];
    }

    public function headings(): array
    {
        return[
            'Nama','Email','username','Alamat','Nomor HP', 'Jabatan'
        ];
    }
    
}
