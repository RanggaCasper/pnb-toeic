<?php  

namespace App\Exports;  

use Maatwebsite\Excel\Concerns\WithTitle;  
use Maatwebsite\Excel\Concerns\WithHeadings;  
use Maatwebsite\Excel\Concerns\WithCustomStartCell;  

class UsersTemplateExport implements WithHeadings, WithCustomStartCell, WithTitle  
{   
    public function headings(): array  
    {  
        return [  
            'Name',  
            'Identity',  
            'Email',  
            'Birthday',  
            'Gender',  
            'Program Study ID',  
        ];  
    }  

    public function startCell(): string  
    {  
        return 'A1';  
    }  

    public function title(): string  
    {  
        return 'Users Template';  
    }  
}  