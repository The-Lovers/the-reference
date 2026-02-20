<!-- FontAwesome -->
<link rel="stylesheet" href="{{ asset('lib/font-awesome-6.5.0/css/all.css') }}"/>

<style>
    :root {
        --bg-light: #ffffff;
        --bg-dark: #1e1e1e;
        --text-light: #333;
        --text-dark: #eee;
        --blue:#0b3c5d;
        --orange:#f57c00;
        --light:#f9f9f9;
        --dark:#1c1c1c;
        --danger: #d9534f;
        --sencondary: #6C757D;
        --info: #5bc0de;
    }

    .popup-container {
        position: fixed;
        z-index: 9999;
        top: 20px;
        right: 20px;
    }

    @media (max-width: 768px) {
        .popup-container {
            left: 50%;
            right: auto;
            transform: translateX(-50%);
            width: 95%;
        }
    }

    .popup {
        background: var(--bg-light);
        color: var(--text-light);
        border-radius: 10px;
        padding: 16px 18px 22px;
        margin-bottom: 10px;
        box-shadow: 0 12px 30px rgba(0,0,0,.2);
        min-width: 280px;
        max-width: 420px;
        position: relative;
        animation: fadeSlide .3s ease;
        overflow: hidden;
    }

    .popup.dark {
        background: var(--bg-dark);
        color: var(--text-dark);
    }

    .popup.confirm {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .popup-icon {
        font-size: 22px;
        margin-bottom: 8px;
    }

    .success { border-left: 5px solid #0b3c5d; }
    .error   { border-left: 5px solid #d9534f; }
    .warning { border-left: 5px solid #f57c00; }
    .info    { border-left: 5px solid #5bc0de; }

    .popup-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 12px;
    }

    .popup-actions button {
        padding: 7px 14px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
    }

    .btn-cancel { background: #7f8c8d; color: #fff; }
    .btn-confirm { background: #0b3c5d; color: #fff; }

    .progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        width: 100%;
        background: rgba(0,0,0,.15);
    }

    .progress-bar {
        height: 100%;
        width: 100%;
        animation: progress linear forwards;
    }

    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="popup-container" id="popup-container"></div>

<script src="{{ asset('lib/font-awesome-6.5.0/js/all.js') }}"></script>
<script src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }}"></script>
<script>
(function () {

    const icons = {
        success: 'fa-circle-check',
        error: 'fa-circle-xmark',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info',
        confirm: 'fa-circle-question'
    };

    window.showPopup = function(type, message, options = {}) {

        const container = document.getElementById('popup-container');
        const popup = document.createElement('div');

        const theme = options.theme === 'dark' ? 'dark' : 'light';
        popup.className = `popup ${type} ${theme}`;

        popup.innerHTML = `
            <div class="popup-icon">
                <i class="fa-solid ${icons[type]}"></i>
            </div>
            <div>${message}</div>
        `;

        // CONFIRM
        if (type === 'confirm') {
            popup.innerHTML += `
                <div class="popup-actions">
                    <button class="btn-cancel">Annuler</button>
                    <button class="btn-confirm">Valider</button>
                </div>
            `;

            container.appendChild(popup);

            popup.querySelector('.btn-cancel').onclick = () => {
                popup.remove();
                options.onCancel && options.onCancel();
            };

            popup.querySelector('.btn-confirm').onclick = () => {
                popup.remove();
                options.onConfirm && options.onConfirm();
            };

            return;
        }

        // AUTRES
        const timeout = options.timeout || 4000;
        let remaining = timeout;
        let startTime;
        let timer;

        const progressBar = document.createElement('div');
        progressBar.className = 'progress';
        progressBar.innerHTML = `
            <div class="progress-bar"
                style="animation-duration:${timeout}ms;
                        background:${getComputedStyle(popup).borderLeftColor}">
            </div>
        `;

        popup.appendChild(progressBar);
        container.appendChild(popup);

        const bar = popup.querySelector('.progress-bar');

        function startTimer() {
            startTime = Date.now();
            bar.style.animationPlayState = 'running';

            timer = setTimeout(() => popup.remove(), remaining);
        }

        function pauseTimer() {
            clearTimeout(timer);
            remaining -= Date.now() - startTime;
            bar.style.animationPlayState = 'paused';
        }

        // Hover pause (desktop)
        popup.addEventListener('mouseenter', pauseTimer);
        popup.addEventListener('mouseleave', startTimer);

        // Touch pause (mobile)
        popup.addEventListener('touchstart', pauseTimer);
        popup.addEventListener('touchend', startTimer);

        // Swipe vers le haut pour fermer
        let startY = 0;
        popup.addEventListener('touchstart', e => {
            startY = e.touches[0].clientY;
        });

        popup.addEventListener('touchend', e => {
            if (startY - e.changedTouches[0].clientY > 60) {
                popup.remove();
            }
        });

        startTimer();
    };

})();
</script>
