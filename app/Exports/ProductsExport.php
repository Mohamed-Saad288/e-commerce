<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProductsExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function __construct(protected $products = null) {}

    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'short_description' => $product->short_description,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'category' => $product->category?->name,
                'brand' => $product->brand?->name,
                'stock' => $product->stock_quantity > 10 ? __('organizations.in_stock') :
                    ($product->stock_quantity > 0 ? __('organizations.low_stock') : __('organizations.out_of_stock')),
                'status' => $product->is_active ? __('messages.active') : __('messages.inactive'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            __('messages.name'),
            __('messages.description'),
            __('messages.short_description'),
            __('messages.slug'),
            __('messages.sku'),
            __('organizations.category'),
            __('organizations.brand'),
            __('organizations.stock'),
            __('messages.status'),
        ];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:N1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:N1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCC99');

        // Set column width
        $sheet->getColumnDimension('A')->setWidth(20); // for name
        $sheet->getColumnDimension('B')->setWidth(40); // for email
        $sheet->getColumnDimension('C')->setWidth(15); // for phone
        $sheet->getColumnDimension('D')->setWidth(20); // for created at
        $sheet->getColumnDimension('E')->setWidth(15); // for id number
        $sheet->getColumnDimension('F')->setWidth(20); // for specialization
        $sheet->getColumnDimension('G')->setWidth(15); // for schs number
        $sheet->getColumnDimension('H')->setWidth(20); // for country
        $sheet->getColumnDimension('I')->setWidth(20); // for city
        $sheet->getColumnDimension('J')->setWidth(35); // for registration fee
        $sheet->getColumnDimension('K')->setWidth(20); // for attend conference
        $sheet->getColumnDimension('L')->setWidth(35); // for type attend
        $sheet->getColumnDimension('M')->setWidth(50); // for workshop
        $sheet->getColumnDimension('N')->setWidth(20); // for employee id

        $sheet->getStyle('A2:N'.(count($this->collection()) + 1))
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    public function title(): string
    {
        return 'Products';
    }
}
