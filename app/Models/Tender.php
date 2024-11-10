<?php

namespace App\Models;

class Tender
{
    public static function getDummyDataForContractor()
    {
        return [
            [
                'id' => 1,
                'title' => 'Tender 1',
                'description' => 'Description for Tender 1',
                'visibility' => 'Public',
                'details' => 'Detailed information about Tender 1',
                'created_at' => '2024-11-10',
            ],
            [
                'id' => 2,
                'title' => 'Tender 2',
                'description' => 'Description for Tender 2',
                'visibility' => 'Private',
                'details' => 'Detailed information about Tender 2',
                'created_at' => '2024-11-10',

            ],
        ];
    }

    public static function getDummyDataForSupplier()
    {
        return [
            [
                'id' => 3,
                'title' => 'Public Tender 1',
                'description' => 'Description for Public Tender 1',
                'visibility' => 'Public',
                'details' => 'Detailed information about Public Tender 1',
                'created_at' => '2024-11-10',

            ],
            [
                'id' => 4,
                'title' => 'Private Tender 1',
                'description' => 'Description for Private Tender 1',
                'visibility' => 'Private',
                'details' => 'Detailed information about Private Tender 1',
                'created_at' => '2024-11-10',

            ],
        ];
    }

    public static function getDummyDataById($id)
    {
        $data = array_merge(self::getDummyDataForContractor(), self::getDummyDataForSupplier());

        foreach ($data as $tender) {
            if ($tender['id'] == $id) {
                return $tender;
            }
        }

        return null;
    }
}
