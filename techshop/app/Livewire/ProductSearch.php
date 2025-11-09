<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product; // <<<< Bổ sung: Phải import Model Product

class ProductSearch extends Component
{
    public $search = '';
    public $totalProducts = 0;

    public function render()
    {
        // Khởi tạo một Collection rỗng để tránh lỗi nếu không có tìm kiếm
        $products = collect(); 
        
        if (!empty($this->search)) {
            
            // Khởi tạo truy vấn cơ sở
            $query = Product::query()
                
                // lọc theo trạng thái 'active' (đang bán)
                ->where('status', 'active')
                
                // Tìm kiếm sản phẩm theo tên
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });

            $this->totalProducts = $query->count();
            
            $products = $query->orderBy('created_at', 'desc')->limit(5)->get();
        } else {
            // Nếu ô tìm kiếm rỗng, đặt lại tổng số kết quả
            $this->totalProducts = 0;
        }

        return view('livewire.product-search', ['products' => $products, 'totalProducts' => $this->totalProducts]);
    }
}