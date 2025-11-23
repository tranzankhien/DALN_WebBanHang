<!-- Cancel Order Popup -->
<div id="cancel-order-popup" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 px-4" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl" role="document">
        <button type="button" class="absolute right-3 top-3 rounded-full bg-gray-100 p-2 text-gray-500 hover:text-gray-700" data-close-cancel-popup aria-label="Đóng">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col items-center text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-red-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="mt-4 text-xl font-semibold text-gray-900">Hủy đơn hàng</h2>
            <p class="mt-2 text-sm text-gray-600">Vui lòng cho chúng tôi biết lý do bạn muốn hủy đơn hàng này.</p>
            
            <form id="cancel-order-form" class="mt-6 w-full" method="POST">
                @csrf
                
                <!-- Predefined reasons -->
                <div class="space-y-2 mb-4">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="cancel_reason_option" value="Tôi muốn thay đổi địa chỉ giao hàng" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-gray-700">Tôi muốn thay đổi địa chỉ giao hàng</span>
                    </label>
                    
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="cancel_reason_option" value="Tôi tìm được sản phẩm giá tốt hơn" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-gray-700">Tôi tìm được sản phẩm giá tốt hơn</span>
                    </label>
                    
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="cancel_reason_option" value="Thời gian giao hàng quá lâu" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-gray-700">Thời gian giao hàng quá lâu</span>
                    </label>
                    
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="cancel_reason_option" value="Đổi ý, không muốn mua nữa" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-gray-700">Đổi ý, không muốn mua nữa</span>
                    </label>
                    
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="cancel_reason_option" value="Đặt nhầm sản phẩm" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-gray-700">Đặt nhầm sản phẩm</span>
                    </label>
                    
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="cancel_reason_option" value="other" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-3 text-sm text-gray-700">Lý do khác</span>
                    </label>
                </div>
                
                <textarea 
                    name="cancel_reason" 
                    id="cancel_reason"
                    rows="3" 
                    placeholder="Nhập lý do khác (tùy chọn)..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                    style="display: none;"
                ></textarea>
                
                <input type="hidden" name="final_cancel_reason" id="final_cancel_reason">
                
                <div class="mt-4 text-left">
                    <p class="text-xs text-gray-500">Lưu ý: Sau khi hủy đơn hàng, bạn không thể hoàn tác thao tác này.</p>
                </div>

                <div class="mt-6 flex flex-col gap-3">
                    <button type="submit" 
                            class="w-full rounded-lg bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700 transition">
                        Xác nhận hủy đơn
                    </button>
                    <button type="button" 
                            data-close-cancel-popup
                            class="w-full rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Không, giữ đơn hàng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('cancel-order-popup');
    const form = document.getElementById('cancel-order-form');
    const cancelButtons = document.querySelectorAll('.cancel-order-btn');
    const closeButtons = document.querySelectorAll('[data-close-cancel-popup]');
    const radioButtons = document.querySelectorAll('input[name="cancel_reason_option"]');
    const otherReasonTextarea = document.getElementById('cancel_reason');
    const finalReasonInput = document.getElementById('final_cancel_reason');

    // Handle radio button changes
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'other') {
                otherReasonTextarea.style.display = 'block';
                otherReasonTextarea.required = true;
                otherReasonTextarea.focus();
            } else {
                otherReasonTextarea.style.display = 'none';
                otherReasonTextarea.required = false;
                otherReasonTextarea.value = '';
            }
        });
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedReason = document.querySelector('input[name="cancel_reason_option"]:checked');
        
        if (!selectedReason) {
            alert('Vui lòng chọn lý do hủy đơn hàng!');
            return;
        }
        
        let finalReason = '';
        if (selectedReason.value === 'other') {
            if (!otherReasonTextarea.value.trim()) {
                alert('Vui lòng nhập lý do hủy đơn hàng!');
                otherReasonTextarea.focus();
                return;
            }
            finalReason = otherReasonTextarea.value.trim();
        } else {
            finalReason = selectedReason.value;
        }
        
        // Create form data
        const formData = new FormData();
        formData.append('_token', form.querySelector('[name="_token"]').value);
        formData.append('cancel_reason', finalReason);
        
        // Submit via fetch
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Có lỗi xảy ra!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi hủy đơn hàng!');
        });
    });

    // Open popup
    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            form.action = `/orders/${orderId}/cancel`;
            popup.classList.remove('hidden');
            popup.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close popup
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            popup.classList.add('hidden');
            popup.classList.remove('flex');
            document.body.style.overflow = '';
            form.reset();
            otherReasonTextarea.style.display = 'none';
            otherReasonTextarea.required = false;
        });
    });

    // Close on backdrop click
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            popup.classList.add('hidden');
            popup.classList.remove('flex');
            document.body.style.overflow = '';
            form.reset();
            otherReasonTextarea.style.display = 'none';
            otherReasonTextarea.required = false;
        }
    });
});
</script>
