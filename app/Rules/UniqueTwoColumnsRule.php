<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueTwoColumnsRule implements ValidationRule
{
    private $table;
    private $column1;
    private $column2;

    public function __construct($table, $column1, $column2, $column2Name , $ignoreId = null)
    {
        $this->table = $table;
        $this->column1 = $column1;
        $this->column2 = $column2;
        $this->column2Name = $column2Name;
        $this->ignoreId = $ignoreId;

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)
            ->where($this->column1, $value)
            ->where($this->column2, $this->column2Name);


        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->count() > 0) {
            $fail('رقم السجل ورمز السجل مستخدمان بالفعل');
        }
    }
}
