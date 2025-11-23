<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-20 right-6 z-[60] space-y-3"></div>

<script>
(function() {
    // Global toast function
    window.showToast = function(message, type = 'success', duration = 4000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast-item transform transition-all duration-300 ease-in-out opacity-0 translate-x-full';
        
        const bgColor = {
            'success': 'bg-green-500',
            'error': 'bg-red-500',
            'warning': 'bg-yellow-500',
            'info': 'bg-blue-500'
        }[type] || 'bg-gray-500';

        const icon = {
            'success': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            'error': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
            'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
            'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
        }[type] || '';

        toast.innerHTML = `
            <div class="${bgColor} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 min-w-[320px] max-w-md">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icon}
                </svg>
                <div class="flex-1 text-sm font-medium">${message}</div>
                <button onclick="this.closest('.toast-item').remove()" class="flex-shrink-0 hover:bg-white/20 rounded p-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('opacity-0', 'translate-x-full');
        });

        // Auto remove
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    };

    // Check for session messages on page load
    @if(session('success'))
        window.showToast("{{ session('success') }}", 'success');
    @endif
    
    @if(session('error'))
        window.showToast("{{ session('error') }}", 'error');
    @endif
    
    @if(session('warning'))
        window.showToast("{{ session('warning') }}", 'warning');
    @endif
    
    @if(session('info'))
        window.showToast("{{ session('info') }}", 'info');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            window.showToast("{{ $error }}", 'error');
        @endforeach
    @endif
})();
</script>
