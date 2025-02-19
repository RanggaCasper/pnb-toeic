<?php  

namespace App\Imports;  

use App\Models\Role;  
use App\Models\User;  
use Maatwebsite\Excel\Concerns\ToModel;  
use Maatwebsite\Excel\Validators\Failure;  
use Maatwebsite\Excel\Concerns\Importable;  
use Maatwebsite\Excel\Concerns\SkipsErrors;  
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;  
use Maatwebsite\Excel\Concerns\SkipsOnFailure;  
use Maatwebsite\Excel\Concerns\WithHeadingRow;  
use Maatwebsite\Excel\Concerns\WithValidation;  
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{  
    use Importable, SkipsErrors, SkipsFailures;

    protected $failures = []; 

    /**  
    * @param array $row  
    *  
    * @return \Illuminate\Database\Eloquent\Model|null  
    */  
    public function model(array $row)  
    {  
        return new User([  
            'name' => $row['name'],  
            'identity' => $row['identity'],  
            'email' => $row['email'],  
            'password' => bcrypt($row['identity']),  
            'birthday' => $this->formatDate($row['birthday']),  
            'gender' => $row['gender'],
            'program_study_id' => $row['program_study_id'],  
            'role_id' => Role::where('name', 'user')->first()->id,  
        ]);  
    }   

    public function rules(): array  
    {  
        return [  
            '*.identity' => ['required', 'max:255', 'unique:users,identity'],  
            '*.name' => ['required', 'max:255'],  
            '*.email' => ['nullable', 'email:dns', 'unique:users,email'],  
            '*.birthday' => ['required'],
            '*.gender' => ['required', 'in:male,female'],  
            '*.program_study_id' => ['required', 'exists:program_studies,id'],  
        ];  
    }  

    public function onFailure(Failure ...$failures)  
    {  
        $this->failures = array_merge($this->failures, $failures);  
    }  

    public function getFailures()  
    {  
        return $this->failures;  
    }  

    private function formatDate($date)  
    {  
        if (is_numeric($date)) {  
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);  
        } else {  
            $date = \DateTime::createFromFormat('d/m/Y', $date);  
        }  
        return $date ? $date->format('Y-m-d') : null;  
    }  
}