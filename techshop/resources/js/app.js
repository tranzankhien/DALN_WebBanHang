import './bootstrap';


document.addEventListener('DOMContentLoaded', () => {
	const popup = document.getElementById('required-login-popup');
	if (!popup) return;

	const body = document.body;
	const openClass = 'flex';

	const openPopup = () => {
		popup.classList.remove('hidden');
		popup.classList.add(openClass);
		popup.setAttribute('aria-hidden', 'false');
		body.classList.add('overflow-hidden');
	};

	const closePopup = () => {
		popup.classList.add('hidden');
		popup.classList.remove(openClass);
		popup.setAttribute('aria-hidden', 'true');
		body.classList.remove('overflow-hidden');
	};

	window.showRequiredLoginPopup = openPopup;
	window.hideRequiredLoginPopup = closePopup;

	document.querySelectorAll('[data-trigger-login-popup]').forEach((trigger) => {
		trigger.addEventListener('click', (event) => {
			event.preventDefault();
			openPopup();
		});
	});

	popup.querySelectorAll('[data-close-login-popup]').forEach((closer) => {
		closer.addEventListener('click', (event) => {
			if (closer.tagName.toLowerCase() !== 'a') {
				event.preventDefault();
			}
			closePopup();
		});
	});

	popup.addEventListener('click', (event) => {
		if (event.target === popup) {
			closePopup();
		}
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && !popup.classList.contains('hidden')) {
			closePopup();
		}
	});
});


