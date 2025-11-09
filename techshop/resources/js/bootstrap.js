import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Initialize Alpine.js (used for small UI interactions like dropdown open/close)
try {
	import('alpinejs').then(({ default: Alpine }) => {
		window.Alpine = Alpine;
		Alpine.start();
	});
} catch (e) {
	// ignore if dynamic import fails in environments where node doesn't support it
}
