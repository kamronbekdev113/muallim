<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Talaffuz Mashqi';

$lettersData = [];
foreach ($letters as $l) {
    $lettersData[] = [
        'name'  => $l->name_uz,
        'trans' => $l->transliteration,
        'iso'   => $l->isolated,
        'letter'=> $l->letter,
        'sound' => $l->soundUrl() ? Url::to($l->soundUrl()) : '',
        'note'  => $l->pronunciation_note ?? '',
    ];
}
$ttsBase = Url::to(['/mashq/tts']);
?>

<div class="container" style="max-width:680px;padding:2rem 1rem 3rem">
    <a href="<?= Url::to(['/alifbo']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Alifboga qaytish
    </a>

    <div class="section-header mt-2">
        <h2><i class="fas fa-microphone mr-2" style="color:var(--gold)"></i>Talaffuz Mashqi</h2>
        <p>Arabcha harfni ko'rib uning o'zbekcha nomini toping</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Rejim tanlash -->
    <div class="d-flex mb-4" style="gap:.75rem;flex-wrap:wrap">
        <button onclick="setMode('name')" id="modeNameBtn" class="btn-muallim" style="font-size:.85rem">
            <i class="fas fa-font mr-1"></i> Ismini top
        </button>
        <button onclick="setMode('letter')" id="modeLetterBtn" class="btn-muallim-outline" style="font-size:.85rem">
            <i class="fas fa-spell-check mr-1"></i> Harfni top
        </button>
        <button onclick="setMode('trans')" id="modeTransBtn" class="btn-muallim-outline" style="font-size:.85rem">
            <i class="fas fa-volume-up mr-1"></i> Transkripsiyani top
        </button>
    </div>

    <!-- Progress -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div style="font-size:.85rem;color:var(--mid-text)">Savol <span id="qNum">0</span> / <span id="qTotal">0</span></div>
        <div>
            <span style="color:#28a745;font-weight:600"><i class="fas fa-check"></i> <span id="scoreOk">0</span></span>
            <span style="color:#dc3545;font-weight:600;margin-left:1rem"><i class="fas fa-times"></i> <span id="scoreErr">0</span></span>
        </div>
    </div>
    <div class="progress mb-4" style="height:6px;border-radius:10px">
        <div id="progressBar" class="progress-bar" style="width:0%;background:var(--gold);transition:.3s"></div>
    </div>

    <!-- Quiz kartasi -->
    <div id="quizCard" style="display:none;background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.08);padding:2rem 1.5rem;text-align:center">
        <div id="questionLabel" style="font-size:.9rem;color:var(--mid-text);margin-bottom:.75rem"></div>

        <!-- Harf ko'rinishi (name va trans rejimida) -->
        <div id="showArabic" style="display:none;font-family:var(--arabic-font);font-size:4.5rem;color:var(--green-deep);line-height:1.2;margin-bottom:1rem"></div>
        <!-- Ism ko'rinishi (letter rejimida) -->
        <div id="showName" style="display:none;font-size:2rem;font-weight:700;color:var(--green-deep);margin-bottom:.5rem"></div>
        <div id="showTrans" style="display:none;font-size:1.3rem;color:var(--mid-text);margin-bottom:1rem"></div>

        <!-- TTS tugma -->
        <button id="ttsBtn" onclick="speakCurrent()" style="background:none;border:1.5px solid var(--gold);border-radius:8px;padding:.4rem .9rem;color:var(--gold);cursor:pointer;margin-bottom:1.5rem;font-size:.85rem">
            <i class="fas fa-volume-up mr-1"></i> Eshitish
        </button>

        <!-- Variantlar -->
        <div id="optionsGrid" class="row" style="margin:0;gap:.5rem;justify-content:center"></div>
    </div>

    <!-- Tushuntirish -->
    <div id="explanation" style="display:none;margin-top:1rem;padding:1rem 1.25rem;background:rgba(27,67,50,.05);border-left:4px solid var(--green-deep);border-radius:0 8px 8px 0"></div>

    <!-- Natija -->
    <div id="resultCard" style="display:none;text-align:center;padding:2.5rem">
        <div style="font-size:3rem;margin-bottom:.5rem" id="resultEmoji">🎉</div>
        <h3>Mashq tugadi!</h3>
        <p>To'g'ri: <strong id="finalOk" style="color:#28a745"></strong> / <span id="finalTotal"></span></p>
        <div id="resultMsg" style="font-size:1rem;color:var(--mid-text);margin-bottom:1.5rem"></div>
        <div class="d-flex justify-content-center" style="gap:1rem">
            <button onclick="startQuiz()" class="btn-muallim">Qayta boshlash</button>
            <a href="<?= Url::to(['/mashq/boglash']) ?>" class="btn-muallim-outline">Bog'lanish mashqi →</a>
        </div>
    </div>

    <!-- Boshlash -->
    <div class="text-center mt-4">
        <button onclick="startQuiz()" class="btn-gold-fill" id="startBtn">
            <i class="fas fa-play mr-2"></i>Boshlash
        </button>
    </div>

    <!-- Harf jadvali (ma'lumot) -->
    <div class="mt-5">
        <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:1rem">📖 Barcha harflar va talaffuz</h5>
        <div class="row" style="gap:.5rem;margin:0">
            <?php foreach ($letters as $l): ?>
            <div style="text-align:center;background:rgba(255,255,255,.8);border:1px solid rgba(201,168,76,.25);border-radius:10px;padding:.6rem .4rem;min-width:70px;cursor:pointer"
                 onclick="playSound('<?= $l->soundUrl() ? Url::to($l->soundUrl()) : '' ?>','<?= htmlspecialchars($l->letter) ?>')"
                 title="Bosing: <?= htmlspecialchars($l->name_uz) ?>">
                <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--green-deep);line-height:1.2"><?= $l->isolated ?></div>
                <div style="font-size:.72rem;color:var(--mid-text)"><?= Html::encode($l->name_uz) ?></div>
                <div style="font-size:.68rem;color:var(--light-text)"><?= Html::encode($l->transliteration) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
const LETTERS = <?= json_encode($lettersData, JSON_UNESCAPED_UNICODE) ?>;
let mode = 'name'; // 'name' | 'letter' | 'trans'
let questions = [], qIdx = 0, scoreOk = 0, scoreErr = 0;
let currentQ = null;

function setMode(m) {
    mode = m;
    document.getElementById('modeNameBtn').className   = m==='name'   ? 'btn-muallim' : 'btn-muallim-outline';
    document.getElementById('modeLetterBtn').className = m==='letter' ? 'btn-muallim' : 'btn-muallim-outline';
    document.getElementById('modeTransBtn').className  = m==='trans'  ? 'btn-muallim' : 'btn-muallim-outline';
}

function shuffle(a){return a.sort(()=>Math.random()-.5);}

function startQuiz(){
    questions = shuffle([...LETTERS]).slice(0,20);
    qIdx=0; scoreOk=0; scoreErr=0;
    document.getElementById('qTotal').textContent = questions.length;
    document.getElementById('startBtn').style.display = 'none';
    document.getElementById('resultCard').style.display = 'none';
    document.getElementById('quizCard').style.display = '';
    nextQuestion();
}

function nextQuestion(){
    if(qIdx>=questions.length){showResult();return;}
    currentQ = questions[qIdx];
    document.getElementById('qNum').textContent = qIdx+1;
    document.getElementById('progressBar').style.width=(qIdx/questions.length*100)+'%';
    document.getElementById('explanation').style.display='none';

    const q = currentQ;
    // Ko'rsatiladigan narsa va savol
    document.getElementById('showArabic').style.display='none';
    document.getElementById('showName').style.display='none';
    document.getElementById('showTrans').style.display='none';

    let qLabel='', correctVal='';
    const pool = shuffle([...LETTERS]).filter(l=>l.name!==q.name).slice(0,3).concat([q]);
    const opts = shuffle(pool);

    if(mode==='name'){
        // Harf ko'rsatiladi, ismini top
        document.getElementById('showArabic').textContent=q.iso;
        document.getElementById('showArabic').style.display='';
        qLabel = 'Bu harfning <strong>o\'zbekcha nomi</strong> qaysi?';
        correctVal = q.name;
        renderOpts(opts, o=>o.name, correctVal, o=>`<div style="font-size:1rem">${o.name}</div><div style="font-size:.75rem;color:var(--mid-text)">${o.trans}</div>`);
    } else if(mode==='letter'){
        // Ism ko'rsatiladi, harfni top
        document.getElementById('showName').textContent=q.name;
        document.getElementById('showName').style.display='';
        document.getElementById('showTrans').textContent='('+q.trans+')';
        document.getElementById('showTrans').style.display='';
        qLabel = 'Bu <strong>ismga mos arabcha harf</strong> qaysi?';
        correctVal = q.iso;
        renderOpts(opts, o=>o.iso, correctVal, o=>`<div style="font-family:'Amiri',serif;font-size:2rem">${o.iso}</div>`);
    } else {
        // Harf ko'rsatiladi, transkripsiyani top
        document.getElementById('showArabic').textContent=q.iso;
        document.getElementById('showArabic').style.display='';
        qLabel = 'Bu harfning <strong>lotin transkripsiyasi</strong> qaysi?';
        correctVal = q.trans;
        renderOpts(opts, o=>o.trans, correctVal, o=>`<div style="font-size:1.1rem;font-weight:600">${o.trans}</div>`);
    }
    document.getElementById('questionLabel').innerHTML=qLabel;
}

function renderOpts(opts, valFn, correctVal, htmlFn){
    const grid=document.getElementById('optionsGrid');
    grid.innerHTML='';
    opts.forEach(o=>{
        const val=valFn(o);
        const btn=document.createElement('div');
        btn.className='col-5';
        btn.innerHTML=`<button onclick="checkAnswer('${val.replace(/'/g,"\\'")}','${correctVal.replace(/'/g,"\\'")}',this)"
            style="width:100%;padding:.75rem .5rem;border:1.5px solid rgba(201,168,76,.35);border-radius:12px;background:#fff;cursor:pointer;transition:.2s;min-height:64px;display:flex;align-items:center;justify-content:center;flex-direction:column">
            ${htmlFn(o)}</button>`;
        grid.appendChild(btn);
    });
}

function checkAnswer(chosen,correct,btn){
    document.querySelectorAll('#optionsGrid button').forEach(b=>b.disabled=true);
    const q=currentQ;
    if(chosen===correct){
        btn.style.background='#28a745';btn.style.color='#fff';btn.style.borderColor='#28a745';
        scoreOk++;document.getElementById('scoreOk').textContent=scoreOk;
    } else {
        btn.style.background='#dc3545';btn.style.color='#fff';btn.style.borderColor='#dc3545';
        document.querySelectorAll('#optionsGrid button').forEach(b=>{
            if(b.textContent.trim()===correct||b.innerHTML.includes(correct)){b.style.background='#28a745';b.style.color='#fff';b.style.borderColor='#28a745';}
        });
        scoreErr++;document.getElementById('scoreErr').textContent=scoreErr;
    }
    // Tushuntirish
    const el=document.getElementById('explanation');
    el.innerHTML=`<div class="d-flex align-items-center" style="gap:1.5rem">
        <div style="font-family:'Amiri',serif;font-size:3rem;color:var(--green-deep)">${q.iso}</div>
        <div>
            <div style="font-weight:700;font-size:1.1rem">${q.name}</div>
            <div style="color:var(--mid-text)">${q.trans}</div>
            ${q.note ? '<div style="font-size:.85rem;color:var(--light-text);margin-top:.25rem">'+q.note+'</div>' : ''}
        </div>
    </div>`;
    el.style.display='';
    qIdx++;
    setTimeout(nextQuestion,1600);
}

function showResult(){
    document.getElementById('quizCard').style.display='none';
    document.getElementById('explanation').style.display='none';
    document.getElementById('resultCard').style.display='';
    document.getElementById('finalOk').textContent=scoreOk;
    document.getElementById('finalTotal').textContent=questions.length;
    const pct=Math.round(scoreOk/questions.length*100);
    document.getElementById('resultEmoji').textContent=pct>=90?'🌟':pct>=70?'🎉':pct>=50?'👍':'💪';
    document.getElementById('resultMsg').textContent=pct>=90?'Ajoyib! Siz harflarni yaxshi bilasiz!':pct>=70?'Yaxshi natija! Davom eting!':'Mashq qilishni davom ettiring!';
    document.getElementById('startBtn').style.display='';
}

const TTS_BASE = <?= json_encode($ttsBase) ?>;
// Google TTS (server proxy) — so'z/harf uchun aniq ovoz; zaxira: brauzer ovozi
function ttsProxy(arabic){
    if(!arabic) return;
    var a=new Audio(TTS_BASE+'?q='+encodeURIComponent(arabic));
    a.onerror=function(){ if('speechSynthesis' in window){var u=new SpeechSynthesisUtterance(arabic);u.lang='ar-SA';u.rate=.8;speechSynthesis.speak(u);} };
    var p=a.play(); if(p&&p.catch) p.catch(function(){});
}
// Harf SOZI (nomi emas): «fa fi fu». Avval LOKAL fayl, bo'lmasa Google proxy.
function letterSound(ch){ return ch+'َ '+ch+'ِ '+ch+'ُ'; }
function playSound(url, ch){
    if(url){
        var a=new Audio(url);
        a.onerror=function(){ ttsProxy(letterSound(ch)); };
        var p=a.play(); if(p&&p.catch) p.catch(function(){ ttsProxy(letterSound(ch)); });
    } else { ttsProxy(letterSound(ch)); }
}
function playLetterSound(ch){ playSound('', ch); }
function speakCurrent(){ if(currentQ) playSound(currentQ.sound, currentQ.letter || currentQ.iso); }
</script>
