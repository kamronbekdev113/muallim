<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Mashqlar Markazi';
?>

<style>
.mashq-hero {
    background: linear-gradient(135deg, var(--green-deep) 0%, #2D6A4F 60%, #1a5c3a 100%);
    padding: 3rem 1rem 4rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.mashq-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cg fill='none' stroke='%23C9A84C' stroke-width='0.3' opacity='0.2'%3E%3Cpolygon points='30,2 38,13 51,13 42,22 45,35 30,28 15,35 18,22 9,13 22,13'/%3E%3Ccircle cx='30' cy='30' r='14'/%3E%3C/g%3E%3C/svg%3E");
    background-size: 60px;
}
.mashq-section { margin-bottom: 2.5rem; }
.mashq-section-title {
    font-size: 1.05rem; font-weight: 700;
    color: var(--green-deep);
    display: flex; align-items: center; gap: .6rem;
    margin-bottom: 1rem; padding-bottom: .5rem;
    border-bottom: 2px solid var(--border);
}
.mashq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(165px, 1fr));
    gap: 1rem;
}
.mashq-card {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 1.4rem 1rem 1.2rem;
    text-align: center;
    text-decoration: none;
    color: var(--dark-text);
    border: 1.5px solid rgba(201,168,76,.2);
    box-shadow: 0 2px 12px rgba(44,24,16,.06);
    transition: all .22s ease;
    position: relative;
    overflow: hidden;
    display: block;
}
.mashq-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}
.mashq-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 28px rgba(44,24,16,.13);
    border-color: var(--gold);
    text-decoration: none;
    color: var(--dark-text);
}
.mashq-card .card-icon { font-size: 2.2rem; margin-bottom: .6rem; line-height: 1; }
.mashq-card .card-name { font-weight: 700; font-size: .95rem; margin-bottom: .25rem; }
.mashq-card .card-desc { font-size: .75rem; color: var(--mid-text); line-height: 1.4; }
.mashq-card .card-badge {
    display: inline-block;
    font-size: .65rem; font-weight: 600; letter-spacing: .04em;
    padding: 2px 8px; border-radius: 20px; margin-top: .5rem;
    text-transform: uppercase;
}
/* Category colors */
.cat-harf::before  { background: linear-gradient(90deg, #1B4332, #40916C); }
.cat-sound::before { background: linear-gradient(90deg, #0d47a1, #1976d2); }
.cat-tajvid::before{ background: linear-gradient(90deg, #4a0080, #7b1fa2); }
.cat-lugat::before { background: linear-gradient(90deg, #C9A84C, #e8c96a); }
.cat-quran::before { background: linear-gradient(90deg, #8B5E3C, #c48a5a); }
.badge-boshlangich { background: rgba(40,167,69,.1); color: #28a745; }
.badge-orta        { background: rgba(255,193,7,.1); color: #e09900; }
.badge-yuqori      { background: rgba(220,53,69,.1); color: #dc3545; }

/* Stats bar */
.stats-strip {
    display: flex; gap: 1rem; flex-wrap: wrap;
    justify-content: center;
    margin: -1.5rem auto 2rem;
    max-width: 700px;
    position: relative; z-index: 2;
}
.stat-pill {
    background: var(--card-bg);
    border-radius: 50px;
    padding: .55rem 1.25rem;
    display: flex; align-items: center; gap: .5rem;
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    font-size: .88rem;
}
.stat-pill strong { color: var(--green-deep); font-size: 1.1rem; }
</style>

<!-- Hero -->
<div class="mashq-hero">
    <div class="position-relative">
        <div style="font-family:var(--arabic-font);font-size:1.8rem;color:rgba(201,168,76,.7);margin-bottom:.4rem">تَعَلَّمْ وَ تَدَرَّبْ</div>
        <h1 style="color:#fff;font-weight:800;font-size:1.8rem;margin-bottom:.4rem">Mashqlar Markazi</h1>
        <p style="color:rgba(255,255,255,.75);font-size:.95rem;margin:0">Arab tilini o'rganishning 9 xil mashq turi</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-strip">
    <div class="stat-pill"><i class="fas fa-dumbbell" style="color:var(--gold)"></i> <strong>12</strong> mashq turi</div>
    <div class="stat-pill"><i class="fas fa-book-open" style="color:var(--green-mid)"></i> <strong>60+</strong> so'z</div>
    <div class="stat-pill"><i class="fas fa-star" style="color:#ffc107"></i> <strong>28</strong> harf</div>
    <div class="stat-pill"><i class="fas fa-quran" style="color:var(--brown)"></i> <strong>12</strong> tajvid qoida</div>
</div>

<div class="container py-3 pb-5" style="max-width:900px">

    <!-- 1. HARFLAR -->
    <div class="mashq-section">
        <div class="mashq-section-title">
            <span style="background:linear-gradient(135deg,#1B4332,#40916C);-webkit-background-clip:text;-webkit-text-fill-color:transparent">🔤 Arabcha Harflar</span>
        </div>
        <div class="mashq-grid">
            <a href="<?= Url::to(['/mashq/harflar']) ?>" class="mashq-card cat-harf">
                <div class="card-icon">🃏</div>
                <div class="card-name">Flashcard</div>
                <div class="card-desc">Kartani ag'darib, harfni eslab qoling</div>
                <span class="card-badge badge-boshlangich">Boshlang'ich</span>
            </a>
            <a href="<?= Url::to(['/mashq/shakl']) ?>" class="mashq-card cat-harf">
                <div class="card-icon">🔷</div>
                <div class="card-name">Harf Shakllari</div>
                <div class="card-desc">4 ta shaklni farqlang: isolated/initial/medial/final</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
            <a href="<?= Url::to(['/mashq/talaffuz']) ?>" class="mashq-card cat-harf">
                <div class="card-icon">🎙️</div>
                <div class="card-name">Talaffuz</div>
                <div class="card-desc">Harfni ko'rib ismini toping (3 rejim)</div>
                <span class="card-badge badge-boshlangich">Boshlang'ich</span>
            </a>
            <a href="<?= Url::to(['/mashq/boglash']) ?>" class="mashq-card cat-harf">
                <div class="card-icon">🔗</div>
                <div class="card-name">Bog'lanish</div>
                <div class="card-desc">Harflar qanday birikishi va shakl o'zgarishi</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
            <a href="<?= Url::to(['/mashq/xotira']) ?>" class="mashq-card cat-harf">
                <div class="card-icon">🧠</div>
                <div class="card-name">Xotira O'yini</div>
                <div class="card-desc">Harf va ismini juftlashtiring</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
            <a href="<?= Url::to(['/mashq/tez-quiz']) ?>" class="mashq-card cat-harf">
                <div class="card-icon">⚡</div>
                <div class="card-name">Tez Quiz</div>
                <div class="card-desc">60 soniya — iloji boricha ko'p savol!</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
        </div>
    </div>

    <!-- 2. HARAKAT VA OVOZ -->
    <div class="mashq-section">
        <div class="mashq-section-title">
            <span style="background:linear-gradient(135deg,#0d47a1,#1976d2);-webkit-background-clip:text;-webkit-text-fill-color:transparent">🔊 Harakat va Ovoz</span>
        </div>
        <div class="mashq-grid">
            <a href="<?= Url::to(['/mashq/harakat']) ?>" class="mashq-card cat-sound">
                <div class="card-icon">◌َ◌ِ◌ُ</div>
                <div class="card-name">Harakat</div>
                <div class="card-desc">Fatha, kasra, damma, sukun va tanwin</div>
                <span class="card-badge badge-boshlangich">Boshlang'ich</span>
            </a>
            <a href="<?= Url::to(['/mashq/soz-test']) ?>" class="mashq-card cat-sound">
                <div class="card-icon">📝</div>
                <div class="card-name">So'z Tarkibi</div>
                <div class="card-desc">So'zdagi harflarni aniqlang (3 rejim)</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
        </div>
    </div>

    <!-- 3. TAJVID -->
    <div class="mashq-section">
        <div class="mashq-section-title">
            <span style="background:linear-gradient(135deg,#4a0080,#7b1fa2);-webkit-background-clip:text;-webkit-text-fill-color:transparent">🎨 Tajvid Qoidalari</span>
        </div>
        <div class="mashq-grid">
            <a href="<?= Url::to(['/mashq/tajvid-test']) ?>" class="mashq-card cat-tajvid">
                <div class="card-icon">☪️</div>
                <div class="card-name">Tajvid Testi</div>
                <div class="card-desc">12 qoidani o'rganing va ranglari bo'yicha toping</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
            <a href="<?= Url::to(['/tajvid']) ?>" class="mashq-card cat-tajvid">
                <div class="card-icon">📖</div>
                <div class="card-name">Qoidalar</div>
                <div class="card-desc">12 tajvid qoidasi batafsil tushuntirish</div>
                <span class="card-badge badge-boshlangich">O'rganish</span>
            </a>
        </div>
    </div>

    <!-- 4. LUG'AT VA QUR'ON -->
    <div class="mashq-section">
        <div class="mashq-section-title">
            <span style="background:linear-gradient(135deg,#C9A84C,#a07832);-webkit-background-clip:text;-webkit-text-fill-color:transparent">📚 Arabcha Lug'at</span>
        </div>
        <div class="mashq-grid">
            <a href="<?= Url::to(['/mashq/lugat']) ?>" class="mashq-card cat-lugat">
                <div class="card-icon">🌟</div>
                <div class="card-name">Qur'on Lug'ati</div>
                <div class="card-desc">60 ta eng ko'p ishlatiladigan Qur'on so'zlari</div>
                <span class="card-badge badge-boshlangich">Boshlang'ich</span>
            </a>
            <a href="<?= Url::to(['/mashq/sozlar']) ?>" class="mashq-card cat-lugat">
                <div class="card-icon">🃏</div>
                <div class="card-name">So'z Flashcard</div>
                <div class="card-desc">Arabcha so'zlar kartochkalari</div>
                <span class="card-badge badge-boshlangich">Boshlang'ich</span>
            </a>
            <a href="<?= Url::to(['/mashq/lugat']) ?>?mode=quiz" class="mashq-card cat-lugat">
                <div class="card-icon">🧩</div>
                <div class="card-name">Lug'at Quizi</div>
                <div class="card-desc">So'z ma'nosini 4 variantdan toping</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
        </div>
    </div>

    <!-- 5. AI MUALLIM -->
    <div class="mashq-section">
        <div class="mashq-section-title">
            <span style="background:linear-gradient(135deg,#0d47a1,#6a1b9a);-webkit-background-clip:text;-webkit-text-fill-color:transparent">🤖 AI Muallim</span>
        </div>
        <div class="mashq-grid">
            <a href="<?= Url::to(['/mashq/ai-muallim']) ?>" class="mashq-card" style="--card-accent:linear-gradient(90deg,#0d47a1,#6a1b9a)">
                <style>.mashq-card[href*='ai-muallim']::before{background:linear-gradient(90deg,#0d47a1,#6a1b9a)}</style>
                <div class="card-icon">🤖</div>
                <div class="card-name">AI Muallim</div>
                <div class="card-desc">Arab tili va Qur'on haqida savol bering — AI javob beradi</div>
                <span class="card-badge" style="background:rgba(13,71,161,.1);color:#0d47a1">AI Chat</span>
            </a>
            <a href="<?= Url::to(['/mashq/gapirish']) ?>" class="mashq-card cat-sound">
                <div class="card-icon">🎤</div>
                <div class="card-name">Gapirish</div>
                <div class="card-desc">Harfni talaffuz qiling — mikrofon real vaqtda baholaydi</div>
                <span class="card-badge badge-orta">O'rta</span>
            </a>
        </div>
    </div>

    <!-- 6. QUR'ON SURA -->
    <div class="mashq-section">
        <div class="mashq-section-title">
            <span style="background:linear-gradient(135deg,#8B5E3C,#c48a5a);-webkit-background-clip:text;-webkit-text-fill-color:transparent">📿 Qur'on va Darslar</span>
        </div>
        <div class="mashq-grid">
            <a href="<?= Url::to(['/mushaf']) ?>" class="mashq-card cat-quran">
                <div class="card-icon">🕌</div>
                <div class="card-name">Tajvidli Mushaf</div>
                <div class="card-desc">114 sura, tajvid ranglari, tarjima</div>
                <span class="card-badge badge-boshlangich">O'qish</span>
            </a>
            <a href="<?= Url::to(['/darslar']) ?>" class="mashq-card cat-quran">
                <div class="card-icon">📘</div>
                <div class="card-name">Muallimi Soniy</div>
                <div class="card-desc">Boshlang'ich Arab tili darslar kursi</div>
                <span class="card-badge badge-boshlangich">O'rganish</span>
            </a>
            <a href="<?= Url::to(['/alifbo']) ?>" class="mashq-card cat-quran">
                <div class="card-icon">أ</div>
                <div class="card-name">Arab Alifbosi</div>
                <div class="card-desc">28 harf, 4 shakl, misollar</div>
                <span class="card-badge badge-boshlangich">O'rganish</span>
            </a>
        </div>
    </div>

</div>
