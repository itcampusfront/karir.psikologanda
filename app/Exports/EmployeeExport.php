<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeExport implements WithHeadings, FromCollection, WithMapping, WithEvents
{

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function collection()
    {
        return $this->employees;
    }

    public function map($employ): array{

        return [
            $employ->user->name,
            $employ->user->email,
            $employ->address,
            $employ->phone_number,
            $employ->birthdate != null ? date('d/m/Y', strtotime($employ->birthdate)) : '',
            $employ->gender,
            $employ->latest_education,
            $employ->start_date != null ? date('d/m/Y', strtotime($employ->start_date)) : '',
            $employ->office->name,
            $employ->position->name,
            $employ->company->name,
            $employ->inspection
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(70);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(23);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(40);
     
            },
        ];
    }

    public function headings(): array
    {
        return[
            'Nama','Email','Alamat','Nomor HP','Tanggal Lahir','Jenis Kelamin','Pend. Terakhir','Awal Bekerja'
            ,'Kantor','Posisi','Perusahaan','Tujuan Pemeriksaan'
        ];
    }
}
