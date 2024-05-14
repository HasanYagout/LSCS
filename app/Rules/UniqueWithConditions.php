<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueWithConditions implements Rule
{
    protected $table;
    protected $column;
    protected $ignoreId;
    protected $ignoreColumn;
    protected $conditions;

    public function __construct($table, $column, $ignoreId = null, $ignoreColumn = 'id', $conditions = [])
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
        $this->ignoreColumn = $ignoreColumn;
        $this->conditions = $conditions;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->where($this->column, $value);

        if ($this->ignoreId !== null) {
            $query->where($this->ignoreColumn, '!=', $this->ignoreId);
        }

        foreach ($this->conditions as $key => $condition) {
            $query->where($key, $condition);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
