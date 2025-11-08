<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;
use App\Models\ProductAttributeValue;

class SampleAttributesSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Bắt đầu điền dữ liệu mẫu cho thuộc tính sản phẩm...');

        // Màn hình mh1
        $mh1 = InventoryItem::where('sku', 'mh1')->first();
        if ($mh1) {
            $this->fillAttributes($mh1, [
                'Tần số quét' => '75Hz',
                'Kích thước' => '27 inch',
                'Độ phân giải' => '2K (2560x1440)',
                'Hãng' => 'ASUS'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho màn hình mh1");
        }

        // Màn hình mh2
        $mh2 = InventoryItem::where('sku', 'mh2')->first();
        if ($mh2) {
            $this->fillAttributes($mh2, [
                'Tần số quét' => '75Hz',
                'Kích thước' => '27 inch',
                'Độ phân giải' => '2K (2560x1440)',
                'Hãng' => 'ASUS'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho màn hình mh2");
        }

        // Tai nghe tn1
        $tn1 = InventoryItem::where('sku', 'tn1')->first();
        if ($tn1) {
            $this->fillAttributes($tn1, [
                'loại' => 'True Wireless',
                'chống ồn' => 'ANC'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho tai nghe tn1");
        }

        // Tai nghe tn2
        $tn2 = InventoryItem::where('sku', 'tn2')->first();
        if ($tn2) {
            $this->fillAttributes($tn2, [
                'loại' => 'True Wireless',
                'chống ồn' => 'ANC'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho tai nghe tn2");
        }

        // Tai nghe tn3
        $tn3 = InventoryItem::where('sku', 'tn3')->first();
        if ($tn3) {
            $this->fillAttributes($tn3, [
                'loại' => 'Chụp tai',
                'chống ồn' => 'ANC'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho tai nghe tn3");
        }

        // Chuột mouse1
        $mouse1 = InventoryItem::where('sku', 'mouse1')->first();
        if ($mouse1) {
            $this->fillAttributes($mouse1, [
                'màu sắc' => 'Đen',
                'DPI' => '8000'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho chuột mouse1");
        }

        // Chuột mouse2
        $mouse2 = InventoryItem::where('sku', 'mouse2')->first();
        if ($mouse2) {
            $this->fillAttributes($mouse2, [
                'màu sắc' => 'Đen',
                'DPI' => '6200'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho chuột mouse2");
        }

        // Chuột mouse3
        $mouse3 = InventoryItem::where('sku', 'mouse3')->first();
        if ($mouse3) {
            $this->fillAttributes($mouse3, [
                'màu sắc' => 'Đen/RGB',
                'DPI' => '26000'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho chuột mouse3");
        }

        // Bàn phím bp1
        $bp1 = InventoryItem::where('sku', 'bp1')->first();
        if ($bp1) {
            $this->fillAttributes($bp1, [
                'màu' => 'Đen/Trắng'
            ]);
            $this->command->line("✓ Đã điền thuộc tính cho bàn phím bp1");
        }

        $this->command->info('✓ Hoàn thành điền dữ liệu mẫu!');
    }

    private function fillAttributes($item, $attributes)
    {
        $categoryAttributes = $item->category->productAttributes;
        
        foreach ($attributes as $attrName => $value) {
            $attr = $categoryAttributes->firstWhere('name', $attrName);
            
            if ($attr) {
                ProductAttributeValue::updateOrCreate(
                    [
                        'inventory_item_id' => $item->id,
                        'attribute_id' => $attr->id,
                    ],
                    [
                        'value' => $value
                    ]
                );
            }
        }
    }
}
