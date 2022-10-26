<?php

namespace App\Services;

class UtilService
{
    public static function paginate($data)
    {
        return [
            'current_page'  => $data->currentPage(),
            'total_page'    => $data->lastPage(),
            'total_rows'    => $data->total(),
        ];
    }
}
