<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = "Qur'on Lug'ati";

$cats = [
    'names'     => ['Alloh sifatlari',  '🌟', '#c9a84c'],
    'verbs'     => ['Fe\'llar',          '⚡', '#0d47a1'],
    'nouns'     => ['Otlar',             '📦', '#1b5e20'],
    'particles' => ['Bo\'lim / Yuklamalar','🔗','#8b0000'],
    'phrases'   => ['Iboralar',          '🤲', '#4a0080'],
];
$grouped = [];
foreach ($words as $w) {
    $grouped[$w->category][] = $w;
}

// JS data
$wordsJson = [];
foreach ($words as $w) {
    $wordsJson[] = [
        'id'    => $w->id,
        'ar'    => $w->word_ar,
        'root'  => $w->root,
        'trans' => $w->transliteration,
        'uz'    => $w->translation_uz,
        'cat'   => $w->category,
        'diff'  => $w->difficulty,
    ];
}

$mode = Yii::$app->request->get('mode', 'browse');
?>
<style>
.vocab-card {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid var(--border);
    padding: 1.1rem;
    text-align: center;
    transition: .2s;
    cursor: pointer;
    position: relative;
}
.vocab-card:hover { border-color:var(--gold); box-shadow:0 4px 16px rgba(201,168,76,.18); transform:translateY(-2px); }
.vocab-ar { font-family:var(--arabic-font); font-size:2rem; color:var(--green-deep); line-height:1.4; direction:rtl; }
.vocab-root { font-size:.7rem; color:var(--light-text); font-family:var(--arabic-font); direction:rtl; margin-top:2px; }
.cat-tab { padding:.4rem 1rem; border-radius:20px; border:1.5px solid var(--border); background:#fff; cursor:pointer; font-size:.82rem; font-weight:600; transition:.2s; }
.cat-tab.active { background:var(--green-deep); color:#fff; border-color:var(--green-deep); }
.cat-tab:hover:not(.active) { border-color:var(--gold); }
</style>

<div class="container" style="max-width:900px;padding:2rem 1rem 3rem">
    <div class="d-flex align-items-center mb-3">
        <a href="<?= Url::to(['/mashq']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
            <i class="fas fa-arrow-left mr-1"></i> Mashqlar
        </a>
    </div>

    <div class="section-header">
        <h2>🌟 Qur'on Lug'ati</h2>
        <p>60 ta eng ko'p ishlatiladigan Qur'on so'zlari — o'zbek tarjimasi bilan</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Rejim tanlash -->
    <div class="d-flex mb-4" style="gap:.6rem;flex-wrap:wrap">
        <a href="<?= Url::to(['/mashq/lugat']) ?>" class="cat-tab <?= $mode==='browse'?'active':'' ?>">
            <i class="fas fa-th mr-1"></i> Ko'rish
        </a>
        <a href="<?= Url::to(['/mashq/lugat'])?>?mode=flash" class="cat-tab <?= $mode==='flash'?'active':'' ?>">
            <i class="fas fa-clone mr-1"></i> Flashcard
        </a>
        <a href="<?= Url::to(['/mashq/lugat'])?>?mode=quiz" class="cat-tab <?= $mode==='quiz'?'active':'' ?>">
            <i class="fas fa-question-circle mr-1"></i> Quiz
        </a>
        <a href="<?= Url::to(['/mashq/lugat'])?>?mode=match" class="cat-tab <?= $mode==='match'?'active':'' ?>">
            <i class="fas fa-puzzle-piece mr-1"></i> Moslashtirish
        </a>
    </div>

    <?php if ($mode === 'browse'): ?>
    <!-- ============ BROWSE ============ -->
    <!-- Category filter -->
    <div class="d-flex mb-3" style="gap:.4rem;flex-wrap:wrap" id="catFilter">
        <button onclick="filterCat('all')" class="cat-tab active" data-cat="all">Barchasi (<?= count($words) ?>)</button>
        <?php foreach ($cats as $k => [$label, $icon, $color]): ?>
        <?php if (!empty($grouped[$k])): ?>
        <button onclick="filterCat('<?= $k ?>')" class="cat-tab" data-cat="<?= $k ?>" style="border-color:<?= $color ?>22">
            <?= $icon ?> <?= $label ?> (<?= count($grouped[$k]) ?>)
        </button>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div id="vocabGrid" class="row" style="margin:0;gap:.75rem">
        <?php foreach ($words as $w): ?>
        <?php [$label,$icon,$color] = $cats[$w->category] ?? ['Boshqa','📌','#888']; ?>
        <div class="vocab-card" data-cat="<?= $w->category ?>" style="min-width:130px;flex:1;max-width:180px"
             onclick="speakWord('<?= htmlspecialchars($w->word_ar) ?>')">
            <?php if ($w->difficulty >= 2): ?>
            <span style="position:absolute;top:6px;right:8px;font-size:.62rem;color:<?= $color ?>;opacity:.7">★★</span>
            <?php endif; ?>
            <div class="vocab-ar"><?= $w->word_ar ?></div>
            <?php if ($w->transliteration): ?>
            <div style="font-size:.72rem;color:var(--mid-text);font-style:italic;margin-top:2px"><?= Html::encode($w->transliteration) ?></div>
            <?php endif; ?>
            <div style="font-size:.82rem;font-weight:600;color:var(--dark-text);margin-top:4px"><?= Html::encode($w->translation_uz) ?></div>
            <?php if ($w->root): ?>
            <div class="vocab-root">اصل: <?= Html::encode($w->root) ?></div>
            <?php endif; ?>
            <div style="margin-top:5px;font-size:.68rem;color:<?= $color ?>"><?= $icon ?> <?= Html::encode($label) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php elseif ($mode === 'flash'): ?>
    <!-- ============ FLASHCARD ============ -->
    <div style="max-width:500px;margin:0 auto">
        <div class="text-center mb-3" style="font-size:.85rem;color:var(--mid-text)">
            <span id="fcIdx">1</span> / <?= count($words) ?>
        </div>
        <div class="flashcard-scene" style="height:260px">
            <div class="flashcard" id="vocabFC">
                <div class="flashcard-face flashcard-front" style="padding:2rem">
                    <div id="fcAr" style="font-family:var(--arabic-font);font-size:3.5rem;color:var(--green-deep);direction:rtl"></div>
                    <div id="fcTrans" style="font-size:1rem;color:var(--mid-text);margin-top:.5rem;font-style:italic"></div>
                    <div style="font-size:.8rem;color:var(--light-text);margin-top:1rem">Bosing — tarjimani ko'ring</div>
                </div>
                <div class="flashcard-face flashcard-back" style="padding:2rem">
                    <div id="fcUz" style="font-size:1.5rem;font-weight:700;color:#fff;margin-bottom:.5rem"></div>
                    <div id="fcRoot" style="font-family:var(--arabic-font);font-size:1.1rem;color:var(--gold)"></div>
                    <div id="fcCat" style="font-size:.78rem;color:rgba(255,255,255,.7);margin-top:.5rem"></div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4" style="gap:1rem">
            <button onclick="fcNav(-1)" class="btn-muallim-outline"><i class="fas fa-arrow-left"></i></button>
            <button onclick="document.getElementById('vocabFC').classList.toggle('flipped')" class="btn-gold-fill">
                <i class="fas fa-sync-alt mr-1"></i> Ag'darish
            </button>
            <button onclick="fcNav(1)" class="btn-muallim"><i class="fas fa-arrow-right"></i></button>
        </div>
        <div class="text-center mt-2" style="font-size:.72rem;color:var(--light-text)">← → klavishlar · Space — ag'darish</div>
    </div>

    <?php elseif ($mode === 'quiz' || $mode === 'match'): ?>
    <!-- ============ QUIZ / MATCH ============ -->
    <div style="max-width:680px;margin:0 auto">
        <div id="quizContainer">
            <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;color:var(--mid-text)">
                <span>Savol <span id="lqNum">0</span>/15</span>
                <span>✓<span id="lqOk" style="color:#28a745;font-weight:600;margin:0 4px">0</span> ✗<span id="lqErr" style="color:#dc3545;font-weight:600;margin-left:4px">0</span></span>
            </div>
            <div class="progress mb-3" style="height:5px;border-radius:10px">
                <div id="lqBar" class="progress-bar" style="width:0%;background:var(--gold);transition:.3s"></div>
            </div>

            <div id="lqCard" style="background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.08);padding:2rem;text-align:center;min-height:260px">
                <div id="lqLabel" style="font-size:.9rem;color:var(--mid-text);margin-bottom:.6rem"></div>
                <div id="lqAr" style="font-family:var(--arabic-font);font-size:3.5rem;color:var(--green-deep);direction:rtl;margin-bottom:.25rem"></div>
                <div id="lqTrans" style="font-size:.9rem;color:var(--mid-text);font-style:italic;margin-bottom:.25rem"></div>
                <button onclick="speakCurrent()" style="background:none;border:1.5px solid var(--gold);border-radius:8px;padding:.25rem .7rem;color:var(--gold);cursor:pointer;font-size:.8rem;margin-bottom:1.25rem">
                    <i class="fas fa-volume-up"></i>
                </button>
                <div id="lqOpts" class="row" style="margin:0;gap:.5rem;justify-content:center"></div>
            </div>
            <div id="lqExpl" style="display:none;margin-top:.75rem;padding:.75rem 1rem;background:rgba(201,168,76,.07);border-left:3px solid var(--gold);border-radius:0 8px 8px 0;font-size:.88rem"></div>
        </div>

        <div id="lqResult" style="display:none;text-align:center;padding:2rem">
            <div style="font-size:3rem;margin-bottom:.5rem" id="lqEmoji">🎉</div>
            <h4>Tugadi!</h4>
            <p>To'g'ri: <strong id="lqFinalOk" style="color:#28a745"></strong>/15</p>
            <div class="d-flex justify-content-center" style="gap:1rem;margin-top:1rem">
                <button onclick="startLQ()" class="btn-muallim">Qayta</button>
                <a href="<?= Url::to(['/mashq/lugat'])?>?mode=<?= $mode==='match'?'quiz':'match' ?>" class="btn-muallim-outline">
                    <?= $mode==='match'?'Quiz rejimi':'Moslashtirish' ?> →
                </a>
            </div>
        </div>

        <div class="text-center mt-3">
            <button onclick="startLQ()" class="btn-gold-fill" id="lqStart">
                <i class="fas fa-play mr-2"></i>Boshlash
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if ($mode === 'match'): ?>
<script>const LQ_MODE='match';</script>
<?php else: ?>
<script>const LQ_MODE='<?= $mode ?>';</script>
<?php endif; ?>

<script>
const VOCAB = <?= json_encode($wordsJson, JSON_UNESCAPED_UNICODE) ?>;
const CAT_LABELS = <?= json_encode(array_map(fn($v) => $v[0], $cats), JSON_UNESCAPED_UNICODE) ?>;

function shuffle(a){return a.sort(()=>Math.random()-.5);}
function speakWord(t){if(!window.speechSynthesis)return;const u=new SpeechSynthesisUtterance(t);u.lang='ar-SA';u.rate=.8;speechSynthesis.speak(u);}

// ---- Browse filter ----
function filterCat(cat){
    document.querySelectorAll('.vocab-card').forEach(c=>{
        c.style.display=(cat==='all'||c.dataset.cat===cat)?'':'none';
    });
    document.querySelectorAll('#catFilter .cat-tab').forEach(b=>{
        b.classList.toggle('active', b.dataset.cat===cat);
    });
}

// ---- Flashcard ----
let fcIdx=0;
const fcData=<?= json_encode($wordsJson, JSON_UNESCAPED_UNICODE) ?>;
function renderFC(){
    if(!fcData.length)return;
    const w=fcData[fcIdx];
    document.getElementById('vocabFC')?.classList.remove('flipped');
    setTimeout(()=>{
        const ar=document.getElementById('fcAr');
        const tr=document.getElementById('fcTrans');
        const uz=document.getElementById('fcUz');
        const rt=document.getElementById('fcRoot');
        if(ar)ar.textContent=w.ar;
        if(tr)tr.textContent=w.trans||'';
        if(uz)uz.textContent=w.uz;
        if(rt)rt.textContent=w.root?'اصل: '+w.root:'';
        const ci=document.getElementById('fcIdx');
        if(ci)ci.textContent=fcIdx+1;
    },100);
}
function fcNav(d){
    fcIdx=(fcIdx+d+fcData.length)%fcData.length;
    renderFC();
}
document.addEventListener('keydown',e=>{
    if(document.getElementById('vocabFC')){
        if(e.key==='ArrowRight')fcNav(1);
        if(e.key==='ArrowLeft')fcNav(-1);
        if(e.key===' '){e.preventDefault();document.getElementById('vocabFC').classList.toggle('flipped');}
    }
});
if(document.getElementById('vocabFC'))renderFC();

// ---- Quiz ----
let lqQs=[], lqIdx=0, lqOk=0, lqErr=0, lqCurrent=null;

function startLQ(){
    lqQs=shuffle([...VOCAB]).slice(0,15);
    lqIdx=0;lqOk=0;lqErr=0;
    document.getElementById('lqStart').style.display='none';
    document.getElementById('lqResult')&&(document.getElementById('lqResult').style.display='none');
    document.getElementById('quizContainer').style.display='';
    nextLQ();
}

function nextLQ(){
    if(lqIdx>=15){showLQResult();return;}
    lqCurrent=lqQs[lqIdx];
    const q=lqCurrent;
    document.getElementById('lqNum').textContent=lqIdx+1;
    document.getElementById('lqBar').style.width=(lqIdx/15*100)+'%';
    document.getElementById('lqExpl').style.display='none';
    document.getElementById('lqAr').textContent=q.ar;
    document.getElementById('lqTrans').textContent=q.trans?'('+q.trans+')':'';

    if(LQ_MODE==='match'){
        // Show Uzbek meaning, find Arabic word
        document.getElementById('lqLabel').innerHTML='Bu ma\'noga mos <strong>arabcha so\'zni</strong> toping';
        document.getElementById('lqAr').textContent='';
        document.getElementById('lqTrans').textContent=q.uz;
        const pool=shuffle(VOCAB.filter(w=>w.id!==q.id)).slice(0,3);
        const opts=shuffle([q,...pool]);
        renderLQOpts(opts,o=>o.ar,q.ar,o=>`<div style="font-family:'Amiri',serif;font-size:2rem">${o.ar}</div><div style="font-size:.75rem;color:var(--mid-text)">${o.trans||''}</div>`);
    } else {
        document.getElementById('lqLabel').innerHTML='Bu so\'zning <strong>o\'zbekcha ma\'nosi</strong> qaysi?';
        const pool=shuffle(VOCAB.filter(w=>w.id!==q.id)).slice(0,3);
        const opts=shuffle([q,...pool]);
        renderLQOpts(opts,o=>o.uz,q.uz,o=>`<div style="font-size:.95rem">${o.uz}</div>`);
    }
}

function renderLQOpts(opts,valFn,correctVal,htmlFn){
    const grid=document.getElementById('lqOpts');
    grid.innerHTML='';
    opts.forEach(o=>{
        const val=valFn(o);
        const d=document.createElement('div');
        d.className='col-5';
        d.innerHTML=`<button onclick="checkLQ(this,'${val.replace(/'/g,"\\'")}','${correctVal.replace(/'/g,"\\'")}')"
            style="width:100%;min-height:60px;padding:.65rem;border:1.5px solid var(--border);border-radius:12px;background:#fff;cursor:pointer;transition:.2s">${htmlFn(o)}</button>`;
        grid.appendChild(d);
    });
}

function checkLQ(btn,chosen,correct){
    document.querySelectorAll('#lqOpts button').forEach(b=>b.disabled=true);
    const q=lqCurrent;
    if(chosen===correct){
        btn.style.background='#28a745';btn.style.color='#fff';btn.style.borderColor='#28a745';
        lqOk++;document.getElementById('lqOk').textContent=lqOk;
    } else {
        btn.style.background='#dc3545';btn.style.color='#fff';btn.style.borderColor='#dc3545';
        document.querySelectorAll('#lqOpts button').forEach(b=>{
            if(b.textContent.trim()===correct||b.innerHTML.includes(correct)){b.style.background='#28a745';b.style.color='#fff';b.style.borderColor='#28a745';}
        });
        lqErr++;document.getElementById('lqErr').textContent=lqErr;
    }
    const el=document.getElementById('lqExpl');
    el.innerHTML=`<span style="font-family:'Amiri',serif;font-size:1.4rem">${q.ar}</span> — <strong>${q.uz}</strong>${q.trans?' ('+q.trans+')':''}${q.root?'<br><span style="font-size:.78rem;color:var(--mid-text)">Ildiz: '+q.root+'</span>':''}`;
    el.style.display='';
    lqIdx++;
    setTimeout(nextLQ,1700);
}

function speakCurrent(){if(lqCurrent)speakWord(lqCurrent.ar);}

function showLQResult(){
    document.getElementById('quizContainer').style.display='none';
    document.getElementById('lqResult').style.display='';
    document.getElementById('lqFinalOk').textContent=lqOk;
    const pct=Math.round(lqOk/15*100);
    document.getElementById('lqEmoji').textContent=pct>=90?'🌟':pct>=70?'🎉':pct>=50?'👍':'💪';
    document.getElementById('lqStart').style.display='';
}

// Auto-start quiz mode
if((LQ_MODE==='quiz'||LQ_MODE==='match')&&document.getElementById('lqStart')){
    // just show the button
}
</script>
