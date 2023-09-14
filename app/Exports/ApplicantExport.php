<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicantExport implements WithHeadings, FromCollection, WithMapping, WithEvents
{
    public function __construct($applicants)
    {
        $this->applicants = $applicants;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->applicants;
    }

    public function map($appli): array
    {
        return[
            $appli->user->name,
            $appli->user->email,
            $appli->address,
            $appli->phone_number,
            $appli->birthdate != null ? date('d/m/Y', strtotime($appli->birthdate)) : '',
            $appli->birthplace,
            gender($appli->gender),
            religion($appli->religion),
            $appli->job_experience,
            $appli->company->name,
            $appli->position ? $appli->position->name : '',
            $appli->inspection
        ];
    }

    public function registerEvents(): array{
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(70);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(23);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(40);
     
            },
        ];
    }

    public function headings(): array
    {
        return[
            'Nama','Email','Alamat','Nomor HP','Tanggal Lahir','Tempat Lahir','Jenis Kelamin','Agama','Riwayat Pekerjaan'
            ,'Kantor','Posisi','Tujuan Pemeriksaan'
        ];
    }
}
