<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentExport implements WithHeadings, FromCollection, WithMapping, WithEvents
{
    public function __construct($students)
    {
        $this->students = $students;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->students;
    }

    public function map($stud): array{

        return [
            $stud->user->name,
            $stud->user->email,
            $stud->address,
            $stud->phone_number,
            $stud->birthdate != null ? date('d/m/Y', strtotime($stud->birthdate)) : '',
            $stud->gender,
            $stud->latest_education,
            $stud->start_date != null ? date('d/m/Y', strtotime($stud->start_date)) : '',
            $stud->office ? $stud->office->name : '',
            $stud->position ? $stud->position->name : '',
            $stud->company->name,
            $stud->inspection
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
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(40);
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
