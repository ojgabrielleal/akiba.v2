<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait ResolvesResourcesFilters
{
    public function filterFields(array $data, array $fields): array
    {
        if(empty($fields)){
            return $data;
        }

        $final = [];

        foreach($fields as $item){
            if(Arr::has($data, $item)){
                Arr::set($final, $item, Arr::get($data, $item));
            }
        }

        return $final;
    }
}
