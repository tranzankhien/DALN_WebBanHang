<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

class CheckProductAttributes extends Command
{
    protected $signature = 'products:check-attributes';
    protected $description = 'Kiểm tra xem các sản phẩm trong kho có đầy đủ thuộc tính của danh mục hay không';

    public function handle()
    {
        $this->info('Bắt đầu kiểm tra thuộc tính sản phẩm...');
        $this->newLine();

        $allItems = InventoryItem::with(['category.productAttributes', 'attributeValues'])->get();
        
        if ($allItems->isEmpty()) {
            $this->warn('Không có sản phẩm nào trong kho!');
            return Command::SUCCESS;
        }

        $totalItems = $allItems->count();
        $itemsWithIssues = 0;
        $itemsComplete = 0;
        $issuesList = [];

        foreach ($allItems as $item) {
            $categoryAttributes = $item->category->productAttributes;
            $itemAttributeValues = $item->attributeValues;
            
            $missingAttributes = [];
            $emptyAttributes = [];
            
            // Kiểm tra từng thuộc tính của danh mục
            foreach ($categoryAttributes as $categoryAttr) {
                $hasAttribute = $itemAttributeValues->firstWhere('attribute_id', $categoryAttr->id);
                
                if (!$hasAttribute) {
                    $missingAttributes[] = $categoryAttr->name;
                } elseif (empty($hasAttribute->value) || trim($hasAttribute->value) === '') {
                    $emptyAttributes[] = $categoryAttr->name;
                }
            }
            
            if (!empty($missingAttributes) || !empty($emptyAttributes)) {
                $itemsWithIssues++;
                $issuesList[] = [
                    'item' => $item,
                    'missing' => $missingAttributes,
                    'empty' => $emptyAttributes,
                ];
            } else {
                $itemsComplete++;
            }
        }

        // Hiển thị thống kê
        $this->newLine();
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('                   THỐNG KÊ TỔNG QUAN');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->line("📦 Tổng số sản phẩm trong kho: {$totalItems}");
        $this->line("✅ Sản phẩm có đầy đủ thuộc tính: <fg=green>{$itemsComplete}</>");
        $this->line("⚠️  Sản phẩm thiếu/rỗng thuộc tính: <fg=yellow>{$itemsWithIssues}</>");
        
        if ($totalItems > 0) {
            $completePercent = round(($itemsComplete / $totalItems) * 100, 2);
            $issuePercent = round(($itemsWithIssues / $totalItems) * 100, 2);
            $this->line("📊 Tỷ lệ hoàn thiện: <fg=green>{$completePercent}%</>");
            $this->line("📊 Tỷ lệ có vấn đề: <fg=yellow>{$issuePercent}%</>");
        }
        $this->info('═══════════════════════════════════════════════════════════');
        $this->newLine();

        // Hiển thị chi tiết các sản phẩm có vấn đề
        if (!empty($issuesList)) {
            $this->error('CHI TIẾT CÁC SẢN PHẨM CÓ VẤN ĐỀ:');
            $this->newLine();
            
            foreach ($issuesList as $index => $issue) {
                $item = $issue['item'];
                $itemNumber = $index + 1;
                $this->line("─────────────────────────────────────────────────────────");
                $this->line("<fg=cyan>#{$itemNumber}</> SKU: <fg=yellow>{$item->sku}</>");
                $this->line("   Tên: {$item->name}");
                $this->line("   Danh mục: {$item->category->name}");
                
                if (!empty($issue['missing'])) {
                    $this->line("   <fg=red>❌ Thiếu thuộc tính:</> " . implode(', ', $issue['missing']));
                }
                
                if (!empty($issue['empty'])) {
                    $this->line("   <fg=yellow>⚠️  Thuộc tính rỗng:</> " . implode(', ', $issue['empty']));
                }
                $this->newLine();
            }
            $this->line("─────────────────────────────────────────────────────────");
        }

        // Hiển thị thống kê theo danh mục
        $this->newLine();
        $this->info('THỐNG KÊ THEO DANH MỤC:');
        $this->newLine();
        
        $categories = Category::with(['inventoryItems', 'productAttributes'])->get();
        
        foreach ($categories as $category) {
            $categoryItems = $category->inventoryItems;
            
            if ($categoryItems->isEmpty()) {
                continue;
            }
            
            $requiredAttrs = $category->productAttributes->count();
            $itemsInCategory = $categoryItems->count();
            $completeInCategory = 0;
            
            foreach ($categoryItems as $item) {
                $hasAllAttributes = true;
                foreach ($category->productAttributes as $attr) {
                    $value = ProductAttributeValue::where('inventory_item_id', $item->id)
                        ->where('attribute_id', $attr->id)
                        ->first();
                    
                    if (!$value || empty($value->value) || trim($value->value) === '') {
                        $hasAllAttributes = false;
                        break;
                    }
                }
                
                if ($hasAllAttributes) {
                    $completeInCategory++;
                }
            }
            
            $categoryCompletePercent = $itemsInCategory > 0 
                ? round(($completeInCategory / $itemsInCategory) * 100, 2) 
                : 0;
            
            $statusIcon = $categoryCompletePercent == 100 ? '✅' : '⚠️';
            $statusColor = $categoryCompletePercent == 100 ? 'green' : 'yellow';
            
            $this->line("{$statusIcon} <fg=cyan>{$category->name}</>");
            $this->line("   Số sản phẩm: {$itemsInCategory}");
            $this->line("   Thuộc tính bắt buộc: {$requiredAttrs}");
            $this->line("   Sản phẩm đầy đủ: <fg={$statusColor}>{$completeInCategory}/{$itemsInCategory} ({$categoryCompletePercent}%)</>");
            $this->newLine();
        }

        $this->newLine();
        $this->info('✓ Hoàn thành kiểm tra!');
        
        return Command::SUCCESS;
    }
}
