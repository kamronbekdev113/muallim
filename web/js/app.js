/* ============================================================
   MUALLIM — app.js
   ============================================================ */

// Dark mode: apply saved theme immediately (before DOMContentLoaded to avoid flash)
(function () {
    if (localStorage.getItem('muallim-theme') === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    }
})();

// Flash toast auto-close
document.addEventListener('DOMContentLoaded', function () {

    // Dark mode toggle
    var themeBtn  = document.getElementById('themeToggle');
    var themeIcon = document.getElementById('themeIcon');
    function syncThemeIcon() {
        if (!themeIcon) return;
        var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
    }
    syncThemeIcon();
    if (themeBtn) {
        themeBtn.addEventListener('click', function () {
            var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            if (isDark) {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('muallim-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('muallim-theme', 'dark');
            }
            syncThemeIcon();
        });
    }
    document.querySelectorAll('.close-toast').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.alert-toast').remove();
        });
    });
    setTimeout(function () {
        document.querySelectorAll('.alert-toast').forEach(function (el) {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.4s';
            setTimeout(function () { el.remove(); }, 400);
        });
    }, 4000);

    // TTS pronunciation buttons
    document.querySelectorAll('.tts-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var text = btn.dataset.text || '';
            var lang = btn.dataset.lang || 'ar-SA';
            if ('speechSynthesis' in window && text) {
                window.speechSynthesis.cancel();
                var utter = new SpeechSynthesisUtterance(text);
                utter.lang = lang;
                utter.rate = 0.85;
                window.speechSynthesis.speak(utter);
            }
        });
    });

    // Flashcard flip
    document.querySelectorAll('.flashcard-scene').forEach(function (scene) {
        scene.addEventListener('click', function () {
            scene.querySelector('.flashcard').classList.toggle('flipped');
        });
    });

    // Keyboard: left/right arrow for flashcard nav
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
            var nextBtn = e.key === 'ArrowRight'
                ? document.querySelector('.fc-next-btn')
                : document.querySelector('.fc-prev-btn');
            if (nextBtn) nextBtn.click();
        }
        if (e.key === ' ' || e.key === 'Enter') {
            var card = document.querySelector('.flashcard');
            if (card) card.classList.toggle('flipped');
        }
    });
});

// Quiz: submit answer via AJAX
function submitQuizAnswer(quizId, optionId, btn) {
    var allBtns = document.querySelectorAll('[data-quiz-id="' + quizId + '"]');
    allBtns.forEach(function (b) { b.disabled = true; });

    var csrf = document.querySelector('meta[name="csrf-token"]') || {};
    fetch('/test/submit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-Token': csrf.content || '' },
        body: '_csrf=' + encodeURIComponent(yii.getCsrfToken()) + '&quiz_id=' + quizId + '&answer=' + optionId
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.correct) {
            btn.classList.add('quiz-correct');
            if (data.xp) showXpPopup(data.xp);
        } else {
            btn.classList.add('quiz-wrong');
            // highlight correct
            allBtns.forEach(function (b) {
                if (b.dataset.correct === '1') b.classList.add('quiz-correct');
            });
        }
    })
    .catch(function () {
        allBtns.forEach(function (b) { b.disabled = false; });
    });
}

function showXpPopup(xp) {
    var el = document.createElement('div');
    el.className = 'xp-popup';
    el.innerHTML = '+' + xp + ' XP';
    document.body.appendChild(el);
    setTimeout(function () { el.remove(); }, 1800);
}

// Flashcard: next/prev by index
var fcIndex = 0;
function fcGo(dir) {
    var cards = document.querySelectorAll('.fc-card-data');
    if (!cards.length) return;
    fcIndex = (fcIndex + dir + cards.length) % cards.length;
    fcUpdate(cards);
}
function fcUpdate(cards) {
    var card = cards[fcIndex];
    if (!card) return;
    var fc = document.querySelector('.flashcard');
    if (fc) fc.classList.remove('flipped');
    document.querySelector('.fc-arabic').textContent  = card.dataset.arabic  || '';
    document.querySelector('.fc-name').textContent    = card.dataset.name    || '';
    document.querySelector('.fc-trans').textContent   = card.dataset.trans   || '';
    document.querySelector('.fc-counter').textContent = (fcIndex + 1) + ' / ' + cards.length;
}
