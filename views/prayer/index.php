<?php
$this->title = 'Namoz Vaqtlari';
?>
<div class="container" style="max-width:600px;padding-top:2rem;padding-bottom:3rem">
    <div class="section-header">
        <h2>🕌 Namoz Vaqtlari</h2>
        <p>Joylashuvingiz bo'yicha bugungi namoz vaqtlari</p>
        <div class="gold-underline"></div>
    </div>

    <div class="prayer-widget">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
            <div id="prayer-city" style="font-size:0.85rem;opacity:0.75">
                <i class="fas fa-map-marker-alt mr-1"></i> Joylashuv aniqlanmoqda...
            </div>
            <button onclick="localStorage.removeItem('muallim_prayer');loadPrayerTimes()"
                    style="background:rgba(255,255,255,0.1);border:none;color:rgba(255,255,255,0.7);padding:4px 12px;border-radius:6px;cursor:pointer;font-size:0.78rem">
                <i class="fas fa-sync-alt mr-1"></i> Yangilash
            </button>
        </div>

        <div class="next-prayer-countdown">
            <div class="countdown-label" id="next-prayer-name">Yuklanmoqda...</div>
            <div class="countdown-time" id="countdown-time">--:--</div>
            <div style="font-size:0.72rem;opacity:0.6;margin-top:0.3rem">keyingi namozgacha</div>
        </div>

        <div id="prayer-loading" style="display:flex;align-items:center;justify-content:center;padding:2rem">
            <i class="fas fa-spinner fa-spin" style="color:var(--gold);font-size:2rem"></i>
        </div>
        <div id="prayer-content" style="display:none">
            <div id="prayer-list"></div>
        </div>
    </div>

    <div class="muallim-card mt-4">
        <h6 style="font-weight:700;color:var(--mid-text);margin-bottom:1rem;text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em">
            NAMOZ HAQIDA
        </h6>
        <p style="color:var(--mid-text);font-size:0.88rem;line-height:1.7">
            Namoz — islomning besh ustunidan biri. Har kuni besh vaqt namoz o'qish har bir musulmon uchun farzdir.
            Bu sahifa joylashuvingiz bo'yicha aniq namoz vaqtlarini ko'rsatadi.
        </p>
        <div class="lesson-arabic" style="font-size:1.4rem;direction:rtl;text-align:right">
            أَقِمِ الصَّلَاةَ لِدُلُوكِ الشَّمْسِ إِلَىٰ غَسَقِ اللَّيْلِ
        </div>
        <div class="lesson-translation">Quyosh botishidan to tun qorong'ilashguncha namozni to'liq o'q (Isro, 78)</div>
    </div>
</div>

<script src="<?= Yii::$app->request->baseUrl ?>/js/prayer.js"></script>
