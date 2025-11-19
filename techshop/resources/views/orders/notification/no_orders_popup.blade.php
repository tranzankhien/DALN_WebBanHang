<!-- No Orders Popup -->
<div id="no-orders-popup" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 px-4" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl" role="document">
        <button type="button" class="absolute right-3 top-3 rounded-full bg-gray-100 p-2 text-gray-500 hover:text-gray-700" data-close-no-orders-popup aria-label="Đóng">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col items-center text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-50 text-gray-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h2 class="mt-4 text-xl font-semibold text-gray-900">Chưa có đơn hàng</h2>
            <p class="mt-2 text-sm text-gray-600">Bạn chưa đặt hàng lần nào. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
            <div class="mt-6 flex w-full flex-col gap-3">
                <a href="{{ route('home') }}" class="w-full rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-3 text-sm font-semibold text-white hover:from-blue-600 hover:to-blue-700" data-close-no-orders-popup>
                    Khám phá sản phẩm
                </a>
                <button type="button" data-close-no-orders-popup class="w-full rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>

<script>
window.showNoOrdersPopup = function() {
    const popup = document.getElementById('no-orders-popup');
    if (popup) {
        popup.classList.remove('hidden');
        popup.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('no-orders-popup');
    const closeButtons = document.querySelectorAll('[data-close-no-orders-popup]');

    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            popup.classList.add('hidden');
            popup.classList.remove('flex');
            document.body.style.overflow = '';
        });
    });

    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            popup.classList.add('hidden');
            popup.classList.remove('flex');
            document.body.style.overflow = '';
        }
    });
});
</script>
