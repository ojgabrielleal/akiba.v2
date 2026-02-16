<?php 

namespace App\Traits;
use Illuminate\Support\Arr;

trait ResolvesResourcesFilters
{
    protected function filterFields(array $data, array $fields = []): array
    {
        if (empty($fields)) {
            return $data;
        }

        $result = [];

        foreach ($fields as $field) {
            if (strpos($field, '.') === false) {
                if (isset($data[$field])) {
                    $result[$field] = $data[$field];
                }
            } else {
                $keys = explode('.', $field);
                $value = $data;
                
                foreach ($keys as $key) {
                    if (is_array($value) && isset($value[$key])) {
                        $value = $value[$key];
                    } else {
                        $value = null;
                        break;
                    }
                }

                if ($value !== null) {
                    $this->setNestedValue($result, $keys, $value);
                }
            }
        }

        return $result;
    }

    protected function setNestedValue(array &$array, array $keys, $value): void
    {
        $current = &$array;
        foreach (array_slice($keys, 0, -1) as $key) {
            if (!isset($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }
        $current[end($keys)] = $value;
    }
}