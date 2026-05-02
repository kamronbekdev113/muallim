/* ============================================================
   MUALLIM — Prayer Times (AlAdhan API + Geolocation)
   ============================================================ */

var PRAYER_NAMES = {
    Fajr:    'Bomdod',
    Sunrise: 'Quyosh',
    Dhuhr:   'Peshin',
    Asr:     'Asr',
    Maghrib: 'Shom',
    Isha:    'Xufton'
};
var PRAYER_ORDER = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];

function loadPrayerTimes() {
    var cached = localStorage.getItem('muallim_prayer');
    if (cached) {
        var obj = JSON.parse(cached);
        if (Date.now() - obj.ts < 3600000) { // 1 hour cache
            renderPrayerTimes(obj.timings, obj.city);
            return;
        }
    }
    // Try geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (pos) {
            fetchByCoords(pos.coords.latitude, pos.coords.longitude);
        }, function () {
            // Fallback: Tashkent
            fetchByCoords(41.2995, 69.2401, 'Toshkent');
        }, { timeout: 6000 });
    } else {
        fetchByCoords(41.2995, 69.2401, 'Toshkent');
    }
}

function fetchByCoords(lat, lng, cityName) {
    var today = new Date();
    var dateStr = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
    var url = 'https://api.aladhan.com/v1/timings/' + dateStr +
              '?latitude=' + lat + '&longitude=' + lng + '&method=1'; // method=1 = MWL

    document.getElementById('prayer-loading').style.display = 'flex';
    document.getElementById('prayer-content').style.display = 'none';

    fetch(url)
        .then(function (r) { return r.json(); })
        .then(function (data) {
            var timings = data.data.timings;
            var meta    = data.data.meta;
            var city    = cityName || (meta.timezone ? meta.timezone.split('/')[1].replace('_', ' ') : 'Sizning shahringiz');
            localStorage.setItem('muallim_prayer', JSON.stringify({ timings: timings, city: city, ts: Date.now() }));
            renderPrayerTimes(timings, city);
        })
        .catch(function () {
            document.getElementById('prayer-loading').innerHTML =
                '<p style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Namoz vaqtlarini yuklashda xato. Internetni tekshiring.</p>';
        });
}

function renderPrayerTimes(timings, city) {
    document.getElementById('prayer-loading').style.display = 'none';
    document.getElementById('prayer-content').style.display = 'block';
    document.getElementById('prayer-city').textContent = city;

    var now = new Date();
    var nowMin = now.getHours() * 60 + now.getMinutes();
    var nextPrayer = null, nextMin = Infinity;

    var html = '';
    PRAYER_ORDER.forEach(function (key) {
        var timeStr = timings[key];
        if (!timeStr) return;
        var parts = timeStr.split(':');
        var pMin = parseInt(parts[0]) * 60 + parseInt(parts[1]);
        var isActive = false;

        if (pMin > nowMin && pMin < nextMin) {
            nextMin = pMin;
            nextPrayer = { name: PRAYER_NAMES[key], time: timeStr, min: pMin };
        }

        html += '<div class="prayer-item' + (isActive ? ' active-prayer' : '') + '" data-min="' + pMin + '">' +
            '<span class="prayer-name">' + PRAYER_NAMES[key] + '</span>' +
            '<span class="prayer-time">' + formatTime(timeStr) + '</span>' +
        '</div>';
    });
    document.getElementById('prayer-list').innerHTML = html;

    // Highlight active (next upcoming)
    if (nextPrayer) {
        document.getElementById('next-prayer-name').textContent = nextPrayer.name + ' vaqtigacha:';
        startCountdown(nextPrayer.min, nowMin);
    } else {
        // After Isha — next is Fajr tomorrow
        var fajrStr = timings['Fajr'];
        document.getElementById('next-prayer-name').textContent = 'Bomdod vaqtigacha (ertaga):';
        if (fajrStr) {
            var fp = fajrStr.split(':');
            var fMin = parseInt(fp[0]) * 60 + parseInt(fp[1]) + 1440;
            startCountdown(fMin, nowMin);
        }
    }

    // Mark active prayer row
    var rows = document.querySelectorAll('.prayer-item');
    var found = false;
    rows.forEach(function (row) {
        var rm = parseInt(row.dataset.min);
        if (!found && rm > nowMin) { row.classList.add('active-prayer'); found = true; }
    });
}

function formatTime(t) {
    var parts = t.split(':');
    var h = parseInt(parts[0]), m = parseInt(parts[1]);
    var ampm = h >= 12 ? 'PM' : 'AM';
    var h12 = h % 12 || 12;
    return h12 + ':' + (m < 10 ? '0' : '') + m + ' ' + ampm;
}

var countdownInterval = null;
function startCountdown(targetMin, nowMin) {
    if (countdownInterval) clearInterval(countdownInterval);
    function update() {
        var now2 = new Date();
        var cur = now2.getHours() * 60 + now2.getMinutes();
        var diff = targetMin - cur;
        if (diff < 0) diff += 1440;
        var h = Math.floor(diff / 60), m = diff % 60;
        var el = document.getElementById('countdown-time');
        if (el) el.textContent = (h > 0 ? h + 's ' : '') + m + ' daqiqa';
    }
    update();
    countdownInterval = setInterval(update, 60000);
}

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('prayer-list')) loadPrayerTimes();
});
