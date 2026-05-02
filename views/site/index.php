<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Bosh sahifa';
$floaters = ['ب','ل','م','ن','ق','ا','ر','س'];
$positions = [
    'top:18%;left:3%;font-size:4.5rem;animation-delay:0s',
    'top:62%;left:6%;font-size:3rem;animation-delay:1.4s',
    'top:22%;right:4%;font-size:5rem;animation-delay:.7s',
    'top:58%;right:7%;font-size:3.5rem;animation-delay:2.1s',
    'top:8%;left:20%;font-size:2.8rem;animation-delay:1.9s',
    'top:72%;right:22%;font-size:3rem;animation-delay:.35s',
    'top:40%;left:2%;font-size:2.4rem;animation-delay:1s',
    'top:35%;right:2%;font-size:2.6rem;animation-delay:2.5s',
];
?>

<!-- ═══════════════════════════════════════════════ HERO -->
<section class="muallim-hero arabesque-bg" style="padding:4.5rem 0 3.5rem;overflow:hidden">
    <div class="container position-relative">
        <?php foreach ($positions as $i => $pos): ?>
        <span class="hero-floating-ar" style="<?= $pos ?>"><?= $floaters[$i] ?></span>
        <?php endforeach; ?>

        <div class="text-center mb-2">
            <span class="hero-hijri"><i class="fas fa-moon mr-1"></i><span id="hijriText">...</span></span>
        </div>
        <div class="hero-bismillah">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
        <h1 style="font-size:clamp(1.9rem,4vw,3rem)">Arab tilini o'rgan,<br>
            <span style="color:var(--gold)">Quronni ravon o'qi</span></h1>
        <p style="max-width:520px">Muallimi Soniydan boshlab, Tajvidli mushafgacha — to'liq o'zbek tilida</p>
        <div class="ornate-divider" style="letter-spacing:10px;font-size:1.2rem">❖ ✦ ❖ ✦ ❖</div>
        <div class="text-center">
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="<?= Url::to(['/royxat']) ?>" class="btn-gold-fill mr-2" style="font-size:.95rem;padding:.7rem 2rem">
                    <i class="fas fa-star mr-1"></i> Bepul boshlash
                </a>
                <a href="<?= Url::to(['/darslar']) ?>" class="btn-muallim-outline" style="color:#fff;border-color:rgba(255,255,255,.4);font-size:.95rem;padding:.7rem 2rem">
                    <i class="fas fa-book-open mr-1"></i> Darslarga qarang
                </a>
            <?php else: ?>
                <?php if ($lastLesson): ?>
                    <a href="<?= Url::to(['/dars/'.$lastLesson->id]) ?>" class="btn-gold-fill mr-2" style="font-size:.95rem;padding:.7rem 2rem">
                        <i class="fas fa-play mr-1"></i> Davom etish
                    </a>
                <?php endif; ?>
                <a href="<?= Url::to(['/mashq']) ?>" class="btn-muallim-outline" style="color:#fff;border-color:rgba(255,255,255,.4);font-size:.95rem;padding:.7rem 2rem">
                    <i class="fas fa-dumbbell mr-1"></i> Mashqlar
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════ QUICK NAV -->
<section class="quick-nav-bar">
    <div class="container position-relative">
        <div class="d-flex justify-content-around flex-wrap" style="gap:.25rem">
            <?php
            $tiles = [
                ['/alifbo',       'fas fa-font',              'Alifbo',    '28 harf'],
                ['/darslar',      'fas fa-book-open',         'Darslar',   'Muallimi Soniy'],
                ['/tajvid',       'fas fa-star-and-crescent', 'Tajvid',    '12 qoida'],
                ['/mushaf',       'fas fa-quran',             'Mushaf',    'Tajvidli'],
                ['/mashq',        'fas fa-dumbbell',          'Mashqlar',  '12 tur'],
                ['/namoz',        'fas fa-mosque',            'Namoz',     'Vaqtlari'],
            ];
            foreach ($tiles as $t): ?>
            <a href="<?= Url::to([$t[0]]) ?>" class="qnav-item" style="min-width:80px;flex:1;max-width:120px">
                <div class="qnav-icon"><i class="<?= $t[1] ?>"></i></div>
                <div class="qnav-label"><?= $t[2] ?></div>
                <div class="qnav-sub"><?= $t[3] ?></div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════ PROGRESS STRIP (login) -->
<?php if (!Yii::$app->user->isGuest): ?>
<?php $user = Yii::$app->user->identity; ?>
<section class="progress-strip">
    <div class="container">
        <div class="d-flex align-items-center flex-wrap" style="gap:.75rem 1.25rem">
            <div class="prog-stat">
                <div class="prog-icon" style="background:rgba(255,107,53,.1)">🔥</div>
                <div><div class="prog-val"><?= $user->streak ?></div><div class="prog-lbl">kun seriya</div></div>
            </div>
            <div class="prog-stat">
                <div class="prog-icon" style="background:rgba(201,168,76,.1)">⭐</div>
                <div><div class="prog-val"><?= number_format($user->xp) ?></div><div class="prog-lbl">XP ball</div></div>
            </div>
            <div class="prog-stat">
                <div class="prog-icon" style="background:rgba(27,67,50,.1)">📖</div>
                <div><div class="prog-val"><?= $completedLessons ?></div><div class="prog-lbl">dars bitirdi</div></div>
            </div>
            <div class="flex-grow-1" style="min-width:160px">
                <div class="d-flex justify-content-between" style="font-size:.7rem;margin-bottom:3px">
                    <span style="font-weight:700;color:<?= $user->getLevelInfo()['color'] ?>"><?= $user->getLevelInfo()['name'] ?></span>
                    <?php $nx=$user->getNextLevel(); if($nx): ?>
                    <span style="color:var(--light-text)"><?= $user->xp ?> / <?= $nx['min_xp'] ?> XP</span>
                    <?php endif; ?>
                </div>
                <div class="progress-muallim">
                    <div class="bar" style="width:<?= $user->getLevelProgress() ?>%;background:<?= $user->getLevelInfo()['color'] ?>"></div>
                </div>
            </div>
            <a href="<?= Url::to(['/profil']) ?>" class="btn-muallim-outline" style="font-size:.78rem;padding:.35rem .9rem;margin-left:auto">
                <i class="fas fa-user mr-1"></i> Profil
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══════════════════════════ PLATFORM STATS BANNER -->
<section class="stats-banner">
    <div class="container position-relative">
        <div class="d-flex justify-content-around align-items-center flex-wrap" style="gap:1rem">
            <?php
            $stats = [
                [$totalLetters, 'Arab harflari',    'حُرُوف'],
                [$totalSurahs,  "Qur'on suralari",  'سُوَر'],
                [6236,          "Qur'on oyatlari",  'آيَات'],
                [12,            'Tajvid qoidalari', 'تَجْوِيد'],
                [$totalLessons, 'Darslar soni',     'دُرُوس'],
            ];
            foreach ($stats as $i => $s): ?>
            <?php if ($i > 0): ?><div class="stat-divider d-none d-md-block"></div><?php endif; ?>
            <div class="stat-counter">
                <div class="stat-counter-num" data-target="<?= $s[0] ?>">0</div>
                <div class="stat-counter-lbl"><?= $s[1] ?></div>
                <span class="stat-counter-ar"><?= $s[2] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════ KUNLIK OYAT -->
<?php if (!empty($dailyAyah)): ?>
<section class="py-section zellige-bg">
    <div class="container">
        <div class="section-ribbon"><i class="fas fa-quran mr-1"></i> KUNLIK OYAT</div>
        <div class="kunlik-oyat-wrap reveal">
            <span class="kunlik-oyat-corner" style="top:-10px;left:8px">ب</span>
            <span class="kunlik-oyat-corner" style="bottom:-10px;right:8px;transform:scaleX(-1)">م</span>
            <div class="position-relative">
                <div class="kunlik-oyat-badge">
                    <i class="fas fa-bookmark"></i>
                    <?php if ($dailyAyah->surah): ?>
                    <?= Html::encode($dailyAyah->surah->name_ar ?? '') ?>
                    &mdash; <?= $dailyAyah->surah_id ?>:<?= $dailyAyah->number ?>
                    <?php endif; ?>
                </div>
                <div class="kunlik-oyat-ar"><?= Html::encode($dailyAyah->text_uthmani ?? '') ?></div>
                <?php if (!empty($dailyAyah->transliteration)): ?>
                <div class="kunlik-oyat-trans"><?= Html::encode($dailyAyah->transliteration) ?></div>
                <?php endif; ?>
                <?php if (!empty($dailyAyah->translation_uz)): ?>
                <div class="kunlik-oyat-uz"><?= Html::encode($dailyAyah->translation_uz) ?></div>
                <?php endif; ?>
                <div class="d-flex align-items-center justify-content-between mt-3 flex-wrap" style="gap:.75rem">
                    <div style="font-size:.78rem;color:var(--gold);font-weight:600">
                        <?php if ($dailyAyah->surah): ?>
                        <i class="fas fa-quran mr-1"></i>
                        <?= Html::encode($dailyAyah->surah->name_uz ?? '') ?> surasi,
                        <?= $dailyAyah->number ?>-oyat
                        <?php endif; ?>
                    </div>
                    <a href="<?= Url::to(['/mushaf/'.($dailyAyah->surah_id ?? 1)]) ?>" class="btn-gold-fill" style="font-size:.8rem;padding:.45rem 1.25rem">
                        <i class="fas fa-book-open mr-1"></i> Surani o'qish
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══════════════════════════ MUALLIMI SONIY BOBLAR -->
<section class="py-section islamic-geo-bg">
    <div class="container">
        <div class="section-header reveal">
            <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--gold);margin-bottom:.4rem">الْمُعَلِّمُ الثَّانِي</div>
            <h2>📚 Muallimi Soniy</h2>
            <p>Arab tilini o'rganishning an'anaviy yo'li — noldan boshlang</p>
            <div class="gold-underline"></div>
        </div>
        <div class="row">
            <?php
            $chAr = ['أ','ب','ت','ث','ج','ح','خ','د'];
            foreach ($chapters as $i => $ch): ?>
            <div class="col-md-6 col-lg-4 mb-3 reveal" style="transition-delay:<?= $i*.06 ?>s">
                <a href="<?= Url::to(['/darslar/'.$ch->number]) ?>" class="chapter-card-v2" data-ar="<?= $chAr[$i] ?? '✦' ?>">
                    <div class="d-flex align-items-center" style="gap:.85rem">
                        <div class="ch-num-badge"><?= $ch->number ?></div>
                        <div style="flex:1;min-width:0">
                            <div style="font-size:.62rem;color:var(--light-text);font-weight:700;text-transform:uppercase;letter-spacing:.08em">Bob <?= $ch->number ?></div>
                            <div style="font-weight:700;color:var(--dark-text);font-size:.97rem"><?= Html::encode($ch->title_uz) ?></div>
                            <div style="font-size:.8rem;color:var(--mid-text)"><?= Html::encode(mb_substr($ch->description_uz??'',0,48)) ?>…</div>
                        </div>
                        <div style="color:var(--gold);font-size:.82rem;text-align:center;flex-shrink:0">
                            <div style="font-weight:800"><?= $ch->getLessonCount() ?></div>
                            <div style="font-size:.64rem;color:var(--light-text)">dars</div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-2">
            <a href="<?= Url::to(['/darslar']) ?>" class="btn-gold-fill">Barcha boblar <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
    </div>
</section>

<!-- ══════════════════════════════ ORNATE DIVIDER -->
<div class="ornate-section-divider zellige-bg">
    <span>❋ &nbsp; بِسْمِ اللَّهِ &nbsp; ❋</span>
</div>

<!-- ══════════════════════════ ARAB HARFLARI PREVIEW -->
<section class="py-section" style="background:var(--parchment-dark)">
    <div class="container">
        <div class="section-header reveal">
            <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--gold);margin-bottom:.4rem">الأَلِفْبَائِيَّة</div>
            <h2>🔤 Arab Alifbosi</h2>
            <p>28 harf — shakllari, talaffuzi va yozilishi</p>
            <div class="gold-underline"></div>
        </div>
        <div class="letter-grid">
            <?php foreach ($letters as $l): ?>
            <a href="<?= Url::to(['/alifbo/'.$l->id]) ?>" class="letter-card">
                <span class="letter-arabic"><?= $l->letter ?></span>
                <span class="letter-name"><?= Html::encode($l->name_uz) ?></span>
                <span class="letter-number"><?= $l->transliteration ?></span>
            </a>
            <?php endforeach; ?>
            <a href="<?= Url::to(['/alifbo']) ?>" class="letter-card" style="background:var(--green-deep);border-color:var(--gold)">
                <span class="letter-arabic" style="color:var(--gold);font-size:1.5rem">→</span>
                <span class="letter-name" style="color:#fff">Hammasi</span>
            </a>
        </div>

        <!-- O'quv yo'li -->
        <div class="section-header reveal" style="padding-top:3rem">
            <h4 style="font-size:1.15rem">🗺️ O'quv yo'li — Yangi talabadan Ustoz darajasiga</h4>
            <div class="gold-underline"></div>
        </div>
        <div class="learning-path">
            <?php
            $steps = [
                ['🌱','Yangi Talaba','Boshlang\'ich'],
                ['🔤','Alifbo','28 harf'],
                ['◌','Harakat','Belgilar'],
                ['☪️','Tajvid','12 qoida'],
                ['📖','Mushaf','Qiroat'],
                ['🏆','Ustoz','Expert'],
            ];
            foreach ($steps as $si => $s): ?>
            <?php if ($si > 0): ?><div class="path-connector"></div><?php endif; ?>
            <div class="path-step">
                <div class="path-circle"><?= $s[0] ?></div>
                <div class="path-lbl"><?= $s[1] ?><br><span style="color:var(--light-text);font-size:.63rem"><?= $s[2] ?></span></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════ TAJVID PREVIEW -->
<section class="py-section mashrabiya-bg">
    <div class="container">
        <div class="section-header reveal">
            <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--gold);margin-bottom:.4rem">أَحْكَامُ التَّجْوِيد</div>
            <h2>🌟 Tajvid Qoidalari</h2>
            <p>Quronni to'g'ri o'qish uchun zarur qoidalar</p>
            <div class="gold-underline"></div>
        </div>
        <div class="tajweed-legend justify-content-center mb-4">
            <span class="legend-item"><span class="legend-dot qalqala"></span>Qalqala</span>
            <span class="legend-item"><span class="legend-dot ghunna"></span>Ghunna</span>
            <span class="legend-item"><span class="legend-dot madd"></span>Madd</span>
            <span class="legend-item"><span class="legend-dot ikhfa"></span>Ikhfa</span>
            <span class="legend-item"><span class="legend-dot idgham"></span>Idgham</span>
            <span class="legend-item"><span class="legend-dot iqlab"></span>Iqlab</span>
            <span class="legend-item"><span class="legend-dot izhar"></span>Izhar</span>
        </div>
        <div class="row">
            <?php foreach ($tajweedRules as $i => $rule): ?>
            <div class="col-md-6 col-lg-3 mb-3 reveal" style="transition-delay:<?= $i*.08 ?>s">
                <a href="<?= Url::to(['/tajvid/'.$rule->id]) ?>" class="tajweed-card">
                    <div class="d-flex align-items-center mb-2" style="gap:.7rem">
                        <div class="tajweed-color-dot" style="background:<?= $rule->color_code ?>"></div>
                        <h6 style="margin:0;font-weight:700"><?= Html::encode($rule->name_uz) ?></h6>
                    </div>
                    <div class="tajweed-arabic text-right"><?= Html::encode($rule->name_ar) ?></div>
                    <p style="font-size:.8rem;color:var(--mid-text);margin:.5rem 0 0"><?= Html::encode(mb_substr($rule->description_uz,0,70)) ?>…</p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-2">
            <a href="<?= Url::to(['/tajvid']) ?>" class="btn-muallim">Barcha qoidalar <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
    </div>
</section>

<!-- ══════════════════════════════ MUSHAF SAMPLE -->
<section class="py-section" style="background:var(--green-deep);position:relative;overflow:hidden">
    <div style="position:absolute;inset:0;opacity:.07;background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Cg fill=%22none%22 stroke=%22%23C9A84C%22 stroke-width=%220.5%22%3E%3Cpolygon points=%2250,3 63,22 85,22 70,37 76,58 50,46 24,58 30,37 15,22 37,22%22/%3E%3C/g%3E%3C/svg%3E');background-size:100px;pointer-events:none"></div>
    <div class="container position-relative">
        <div class="section-header" style="color:#fff">
            <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--gold);margin-bottom:.4rem">الْمُصْحَف الشَّرِيف</div>
            <h2 style="color:#fff">📖 Tajvidli Mushaf</h2>
            <p style="color:rgba(255,255,255,.75)">Ranglar bilan belgilangan — barcha 114 sura, 6236 oyat</p>
            <div class="gold-underline"></div>
        </div>
        <div class="mushaf-wrapper" style="max-width:700px;margin:0 auto">
            <div class="mushaf-bismillah">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
            <div class="ayah-row">
                <div class="ayah-text">الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ <span class="ayah-number">٢</span></div>
                <div class="ayah-translation">Barcha hamdu sanolar olamlar Rabbiga xosdir</div>
            </div>
            <div class="ayah-row">
                <div class="ayah-text">الرَّحْمَٰنِ الرَّحِيمِ <span class="ayah-number">٣</span></div>
                <div class="ayah-translation">Mehribon va rahmli zot</div>
            </div>
            <div class="ayah-row">
                <div class="ayah-text">مَالِكِ يَوْمِ الدِّينِ <span class="ayah-number">٤</span></div>
                <div class="ayah-translation">Din (hisob-kitob) kunining Hukmdori</div>
            </div>
            <div class="text-center mt-3" style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap">
                <a href="<?= Url::to(['/mushaf/1']) ?>" class="btn-gold-fill">
                    <i class="fas fa-quran mr-1"></i> Al-Fotiha to'liq
                </a>
                <a href="<?= Url::to(['/mushaf']) ?>" class="btn-muallim-outline" style="color:#fff;border-color:rgba(255,255,255,.35)">
                    <i class="fas fa-list mr-1"></i> Barcha suralar
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════ MASHQLAR CTA -->
<section class="py-section" style="background:var(--parchment-dark)">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0 reveal">
                <div class="section-ribbon"><i class="fas fa-dumbbell mr-1"></i> MASHQLAR MARKAZI</div>
                <div style="font-family:var(--arabic-font);font-size:1.6rem;color:var(--gold);margin-bottom:.4rem">تَعَلَّمْ وَتَدَرَّبْ</div>
                <h2 style="font-size:1.7rem;margin-bottom:.75rem">12 xil mashq turi</h2>
                <p style="color:var(--mid-text);line-height:1.8">
                    Flashcard, Xotira o'yini, Tez Quiz, Gapirish mashqi, Tajvid testi,
                    Lug'at, Harf shakllari va boshqa mashqlar orqali Arab tilini mustahkamlang.
                </p>
                <div class="d-flex flex-wrap" style="gap:.6rem;margin-top:1.25rem">
                    <a href="<?= Url::to(['/mashq']) ?>" class="btn-gold-fill"><i class="fas fa-dumbbell mr-1"></i> Barcha mashqlar</a>
                    <a href="<?= Url::to(['/mashq/gapirish']) ?>" class="btn-muallim-outline"><i class="fas fa-microphone mr-1"></i> Gapirish mashqi</a>
                    <a href="<?= Url::to(['/mashq/xotira']) ?>" class="btn-muallim-outline"><i class="fas fa-brain mr-1"></i> Xotira o'yini</a>
                </div>
            </div>
            <div class="col-lg-5 reveal" style="transition-delay:.15s">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.85rem">
                    <?php
                    $mCards = [
                        ['🃏','Flashcard',    'Kartani ag\'darish'],
                        ['🧠','Xotira O\'yini','Juftlashtirish'],
                        ['⚡','Tez Quiz',      '60 soniya'],
                        ['🎤','Gapirish',      'Ovoz tahlili'],
                        ['🌟','Tajvid Testi',  '3 rejim'],
                        ['📚','Lug\'at',       '60+ so\'z'],
                    ];
                    foreach ($mCards as $mc): ?>
                    <a href="<?= Url::to(['/mashq']) ?>" style="background:var(--card-bg);border:1px solid var(--border);border-radius:14px;padding:.9rem;text-decoration:none;color:var(--dark-text);transition:.2s;display:flex;align-items:center;gap:.6rem" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
                        <span style="font-size:1.4rem"><?= $mc[0] ?></span>
                        <div>
                            <div style="font-size:.82rem;font-weight:700"><?= $mc[1] ?></div>
                            <div style="font-size:.7rem;color:var(--mid-text)"><?= $mc[2] ?></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════ ORNATE DIVIDER 2 -->
<div class="ornate-section-divider" style="background:var(--parchment)">
    <span>✦ اللَّهُ أَكْبَر ✦</span>
</div>

<!-- ══════════════════════════════ NAMOZ WIDGET -->
<section class="py-section">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="section-header text-left" style="padding-top:0">
                    <div style="font-family:var(--arabic-font);font-size:1.6rem;color:var(--gold);margin-bottom:.4rem">مَوَاقِيتُ الصَّلَاة</div>
                    <h2>🕌 Namoz Vaqtlari</h2>
                    <p>Bugungi namoz vaqtlari (geolokatsiya asosida)</p>
                    <div class="gold-underline" style="margin-left:0"></div>
                </div>
                <p style="color:var(--mid-text);line-height:1.8">Platformamizda o'rganish bilan bir qatorda kundalik namoz vaqtlarini kuzatib boring.</p>
                <a href="<?= Url::to(['/namoz']) ?>" class="btn-muallim mt-2">Vaqtlarni ko'rish <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            <div class="col-lg-6">
                <div class="prayer-widget">
                    <div id="prayer-city" style="font-size:.75rem;opacity:.7;margin-bottom:.5rem"><i class="fas fa-map-marker-alt mr-1"></i> Joylashuv aniqlanmoqda...</div>
                    <div class="next-prayer-countdown">
                        <div class="countdown-label" id="next-prayer-name">Yuklanmoqda...</div>
                        <div class="countdown-time" id="countdown-time">--:--</div>
                    </div>
                    <div id="prayer-loading" style="display:flex;align-items:center;justify-content:center;padding:1rem">
                        <i class="fas fa-spinner fa-spin" style="color:var(--gold);font-size:1.5rem"></i>
                    </div>
                    <div id="prayer-content" style="display:none"><div id="prayer-list"></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= Yii::$app->request->baseUrl ?>/js/prayer.js"></script>
<script>
// Hijri date
(function(){
    try {
        var h = new Intl.DateTimeFormat('ar-SA', {calendar:'islamic-umalqura',day:'numeric',month:'long',year:'numeric'}).format(new Date());
        document.getElementById('hijriText').textContent = h;
    } catch(e) { document.querySelector('.hero-hijri').style.display='none'; }
})();

// Animated counters + scroll reveal
document.addEventListener('DOMContentLoaded', function(){
    function countUp(el){
        var t=parseInt(el.dataset.target)||0, dur=1400, start=null;
        (function step(ts){
            if(!start) start=ts;
            var p=Math.min((ts-start)/dur,1), e=1-Math.pow(1-p,3);
            el.textContent=Math.floor(e*t).toLocaleString();
            if(p<1) requestAnimationFrame(step);
            else el.textContent=t.toLocaleString();
        })(performance.now());
    }
    var io1=new IntersectionObserver(function(en){en.forEach(function(e){if(e.isIntersecting){countUp(e.target);io1.unobserve(e.target);}});},{threshold:.3});
    document.querySelectorAll('[data-target]').forEach(function(el){io1.observe(el);});
    var io2=new IntersectionObserver(function(en){en.forEach(function(e){if(e.isIntersecting){e.target.classList.add('visible');}});},{threshold:.08});
    document.querySelectorAll('.reveal').forEach(function(el){io2.observe(el);});
});
</script>
