<?php

namespace App\Support;

class StoreCatalog
{
    public static function products(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'OnePlus Nord CE',
                'category' => 'Gadget',
                'description' => 'Smartphone berperforma tinggi dengan desain minimalis.',
                'price' => 3999000,
                'stock' => 10,
                'image' => '',
            ],
            [
                'id' => 2,
                'name' => 'Gaming Mouse Pro',
                'category' => 'Gaming',
                'description' => 'Mouse gaming dengan sensor presisi tinggi.',
                'price' => 549000,
                'stock' => 10,
                'image' => '',
            ],
            [
                'id' => 3,
                'name' => 'Wireless Earbuds TWS',
                'category' => 'Gadget',
                'description' => 'Earbuds wireless dengan fitur noise cancellation.',
                'price' => 499000,
                'stock' => 10,
                'image' => '',
            ],
            [
                'id' => 4,
                'name' => 'Mechanical Keyboard RGB',
                'category' => 'Gaming',
                'description' => 'Keyboard mechanical dengan lampu RGB.',
                'price' => 799000,
                'stock' => 10,
                'image' => '',
            ],
            [
                'id' => 5,
                'name' => 'Laptop Sleeve 14 Inch',
                'category' => 'Aksesoris',
                'description' => 'Sleeve laptop berbahan tahan air.',
                'price' => 179000,
                'stock' => 10,
                'image' => '',
            ],
            [
                'id' => 6,
                'name' => 'LED Monitor 24 Inch',
                'category' => 'Computer',
                'description' => 'Monitor Full HD untuk pekerjaan dan hiburan.',
                'price' => 1599000,
                'stock' => 10,
                'image' => '',
            ],
        ];
    }

    public static function find(int $id): ?array
    {
        foreach (self::products() as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }

        return null;
    }
}
