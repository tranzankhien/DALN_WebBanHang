<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InventoryItem;
use App\Models\ProductAttributeValue;

class FillMissingAttributes extends Command
{
    protected $signature = 'products:fill-attributes {sku?}';
    protected $description = 'Điền thông tin thuộc tính còn thiếu cho sản phẩm';

    public function handle()
    {
        $sku = $this->argument('sku');
        
        if ($sku) {
            // Fill attributes for specific product
            $this->fillSingleProduct($sku);
        } else {
            // Fill attributes for all products with missing attributes
            $this->fillAllProducts();
        }
        
        return Command::SUCCESS;
    }
    
    protected function fillSingleProduct($sku)
    {
        $item = InventoryItem::where('sku', $sku)
            ->with(['category.productAttributes', 'attributeValues'])
            ->first();
        
        if (!$item) {
            $this->error("Không tìm thấy sản phẩm với SKU: {$sku}");
            return;
        }
        
        $this->info("Sản phẩm: {$item->name}");
        $this->info("Danh mục: {$item->category->name}");
        $this->newLine();
        
        $categoryAttributes = $item->category->productAttributes;
        
        if ($categoryAttributes->isEmpty()) {
            $this->warn('Danh mục này không có thuộc tính nào!');
            return;
        }
        
        foreach ($categoryAttributes as $attr) {
            $existingValue = $item->attributeValues->firstWhere('attribute_id', $attr->id);
            
            if ($existingValue && !empty($existingValue->value)) {
                $this->line("<fg=green>✓</> {$attr->name}: {$existingValue->value}");
            } else {
                $unit = $attr->unit ? " ({$attr->unit})" : '';
                $value = $this->ask("Nhập {$attr->name}{$unit}");
                
                if (!empty($value)) {
                    if ($existingValue) {
                        $existingValue->update(['value' => $value]);
                        $this->info("  → Đã cập nhật!");
                    } else {
                        ProductAttributeValue::create([
                            'inventory_item_id' => $item->id,
                            'attribute_id' => $attr->id,
                            'value' => $value,
                        ]);
                        $this->info("  → Đã thêm mới!");
                    }
                } else {
                    $this->warn("  → Bỏ qua (không nhập giá trị)");
                }
            }
        }
        
        $this->newLine();
        $this->info('✓ Hoàn thành cập nhật sản phẩm!');
    }
    
    protected function fillAllProducts()
    {
        $this->info('Tìm kiếm sản phẩm thiếu thuộc tính...');
        $this->newLine();
        
        $allItems = InventoryItem::with(['category.productAttributes', 'attributeValues'])->get();
        $itemsWithIssues = [];
        
        foreach ($allItems as $item) {
            $categoryAttributes = $item->category->productAttributes;
            
            if ($categoryAttributes->isEmpty()) {
                continue;
            }
            
            $missingCount = 0;
            foreach ($categoryAttributes as $attr) {
                $hasValue = $item->attributeValues->firstWhere('attribute_id', $attr->id);
                if (!$hasValue || empty($hasValue->value)) {
                    $missingCount++;
                }
            }
            
            if ($missingCount > 0) {
                $itemsWithIssues[] = [
                    'item' => $item,
                    'missing' => $missingCount,
                    'total' => $categoryAttributes->count(),
                ];
            }
        }
        
        if (empty($itemsWithIssues)) {
            $this->info('✓ Tất cả sản phẩm đã có đầy đủ thuộc tính!');
            return;
        }
        
        $this->warn("Tìm thấy " . count($itemsWithIssues) . " sản phẩm thiếu thuộc tính:");
        $this->newLine();
        
        foreach ($itemsWithIssues as $index => $issue) {
            $item = $issue['item'];
            $this->line(($index + 1) . ". [{$item->sku}] {$item->name}");
            $this->line("   Danh mục: {$item->category->name}");
            $this->line("   Thiếu: {$issue['missing']}/{$issue['total']} thuộc tính");
            $this->newLine();
        }
        
        if ($this->confirm('Bạn có muốn điền thông tin từng sản phẩm không?', true)) {
            foreach ($itemsWithIssues as $issue) {
                $this->line('─────────────────────────────────────────────────────────');
                $this->fillSingleProduct($issue['item']->sku);
                $this->newLine();
                
                if (!$this->confirm('Tiếp tục với sản phẩm tiếp theo?', true)) {
                    break;
                }
            }
        } else {
            $this->info('Bạn có thể điền thuộc tính cho từng sản phẩm bằng lệnh:');
            $this->comment('php artisan products:fill-attributes {sku}');
        }
    }
}
