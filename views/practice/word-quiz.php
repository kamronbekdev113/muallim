<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "So'z va Harf Mashqi";
?>

<div class="container" style="max-width:720px;padding:2rem 1rem 3rem">
    <a href="<?= Url::to(['/alifbo']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Alifboga qaytish
    </a>

    <div class="section-header mt-2">
        <h2><i class="fas fa-book-open mr-2" style="color:var(--gold)"></i>So'z va Harf Mashqi</h2>
        <p>Arabcha so'zlarni o'qing, harflar tarkibini tahlil qiling</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Rejim tanlash -->
    <div class="d-flex mb-4" style="gap:.75rem;flex-wrap:wrap">
        <button onclick="setMode('meaning')" id="modeMeaningBtn" class="btn-muallim" style="font-size:.85rem">
            <i class="fas fa-language mr-1"></i> Ma'nosi nima?
        </button>
        <button onclick="setMode('startletter')" id="modeStartBtn" class="btn-muallim-outline" style="font-size:.85rem">
            <i class="fas fa-search mr-1"></i> Qaysi harf bilan boshlanadi?
        </button>
        <button onclick="setMode('count')" id="modeCountBtn" class="btn-muallim-outline" style="font-size:.85rem">
            <i class="fas fa-calculator mr-1"></i> Nechi harf?
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
    <div id="quizCard" style="display:none;background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.08);padding:2rem;text-align:center">
        <div id="qLabel" style="font-size:.9rem;color:var(--mid-text);margin-bottom:.75rem"></div>

        <!-- Arabcha so'z -->
        <div id="qWord" style="font-family:var(--arabic-font);font-size:3.5rem;color:var(--green-deep);margin-bottom:.25rem;line-height:1.3"></div>

        <!-- Transliteratsiya + TTS -->
        <div style="margin-bottom:1.25rem;display:flex;align-items:center;justify-content:center;gap:.75rem">
            <div id="qTrans" style="font-size:1rem;color:var(--mid-text);font-style:italic"></div>
            <button onclick="speakCurrent()" style="background:none;border:1.5px solid var(--gold);border-radius:8px;padding:.25rem .6rem;color:var(--gold);cursor:pointer;font-size:.8rem">
                <i class="fas fa-volume-up"></i>
            </button>
        </div>

        <!-- Variantlar -->
        <div id="optionsGrid" class="row" style="margin:0;gap:.5rem;justify-content:center"></div>
    </div>

    <!-- Tushuntirish -->
    <div id="explanation" style="display:none;margin-top:1rem;padding:1rem 1.25rem;background:rgba(27,67,50,.05);border-left:4px solid var(--green-deep);border-radius:0 8px 8px 0;font-size:.9rem"></div>

    <!-- Natija -->
    <div id="resultCard" style="display:none;text-align:center;padding:2.5rem">
        <div id="resultEmoji" style="font-size:3rem;margin-bottom:.5rem">🎉</div>
        <h3>Mashq tugadi!</h3>
        <p>To'g'ri: <strong id="finalOk" style="color:#28a745"></strong> / <span id="finalTotal"></span></p>
        <div class="d-flex justify-content-center mt-3" style="gap:1rem">
            <button onclick="startQuiz()" class="btn-muallim">Qayta boshlash</button>
            <a href="<?= Url::to(['/mashq/harflar']) ?>" class="btn-muallim-outline">Flashcard →</a>
        </div>
    </div>

    <!-- Boshlash -->
    <div class="text-center mt-4">
        <button onclick="startQuiz()" class="btn-gold-fill" id="startBtn">
            <i class="fas fa-play mr-2"></i>Boshlash
        </button>
    </div>

    <!-- So'zlar lug'ati -->
    <div class="mt-5">
        <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:1rem">📚 So'zlar to'plami</h5>
        <div class="row" style="gap:.5rem;margin:0">
            <?php foreach (array_slice($words, 0, 30) as $w): ?>
            <div style="background:rgba(255,255,255,.8);border:1px solid rgba(201,168,76,.25);border-radius:10px;padding:.6rem .75rem;cursor:pointer;text-align:center;min-width:90px"
                 onclick="speakWord('<?= htmlspecialchars($w['ar']) ?>')">
                <div style="font-family:var(--arabic-font);font-size:1.6rem;color:var(--green-deep);direction:rtl"><?= $w['ar'] ?></div>
                <div style="font-size:.72rem;color:var(--dark-text);margin-top:2px"><?= Html::encode($w['uz']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
// All unique letters for options
$allLetterNames = array_map(fn($l) => $l->name_uz, $letters);
?>

<script>
const WORDS   = <?= json_encode($words, JSON_UNESCAPED_UNICODE) ?>;
const LETTERS_ALL = <?= json_encode($allLetterNames, JSON_UNESCAPED_UNICODE) ?>;
let mode='meaning', questions=[], qIdx=0, scoreOk=0, scoreErr=0, currentQ=null;

function setMode(m){
    mode=m;
    document.getElementById('modeMeaningBtn').className=m==='meaning'?'btn-muallim':'btn-muallim-outline';
    document.getElementById('modeStartBtn').className=m==='startletter'?'btn-muallim':'btn-muallim-outline';
    document.getElementById('modeCountBtn').className=m==='count'?'btn-muallim':'btn-muallim-outline';
    document.getElementById('modeMeaningBtn').style.fontSize='.85rem';
    document.getElementById('modeStartBtn').style.fontSize='.85rem';
    document.getElementById('modeCountBtn').style.fontSize='.85rem';
}

function shuffle(a){return a.sort(()=>Math.random()-.5);}

function startQuiz(){
    if(!WORDS.length){alert("So'zlar topilmadi.");return;}
    questions=shuffle([...WORDS]).slice(0,15);
    qIdx=0;scoreOk=0;scoreErr=0;
    document.getElementById('qTotal').textContent=questions.length;
    document.getElementById('startBtn').style.display='none';
    document.getElementById('resultCard').style.display='none';
    document.getElementById('quizCard').style.display='';
    nextQ();
}

function nextQ(){
    if(qIdx>=questions.length){showResult();return;}
    currentQ=questions[qIdx];
    const q=currentQ;
    document.getElementById('qNum').textContent=qIdx+1;
    document.getElementById('progressBar').style.width=(qIdx/questions.length*100)+'%';
    document.getElementById('explanation').style.display='none';
    document.getElementById('qWord').textContent=q.ar;
    document.getElementById('qTrans').textContent='('+q.trans+')';

    let qLabel='',correctVal='',opts=[],optHtml=o=>'';

    if(mode==='meaning'){
        qLabel="Bu so'zning <strong>o'zbekcha ma'nosi</strong> qaysi?";
        correctVal=q.uz;
        const wrongPool=shuffle(WORDS.filter(w=>w.uz!==q.uz)).slice(0,3).map(w=>w.uz);
        opts=shuffle([correctVal,...wrongPool]);
        optHtml=v=>`<div style="font-size:.95rem">${v}</div>`;
    } else if(mode==='startletter'){
        qLabel="Bu so'z <strong>qaysi harf</strong> bilan boshlanadi?";
        correctVal=q.letter;
        const wrong=shuffle(LETTERS_ALL.filter(l=>l!==q.letter)).slice(0,3);
        opts=shuffle([correctVal,...wrong]);
        optHtml=v=>`<div style="font-size:.9rem">${v}</div>`;
    } else {
        // Count letters (estimate: chars without diacritics)
        const clean=q.ar.replace(/[\u064B-\u065F\u0610-\u061A]/g,'');
        const cnt=clean.length;
        correctVal=String(cnt);
        const wrongs=[];
        for(let i=1;i<=8;i++){if(String(i)!==correctVal)wrongs.push(String(i));}
        opts=shuffle([correctVal,...shuffle(wrongs).slice(0,3)]);
        qLabel=`Bu so'zda <strong>nechi harf</strong> bor?`;
        optHtml=v=>`<div style="font-size:1.2rem;font-weight:700">${v} ta</div>`;
    }

    document.getElementById('qLabel').innerHTML=qLabel;
    const grid=document.getElementById('optionsGrid');
    grid.innerHTML='';
    opts.forEach(opt=>{
        const d=document.createElement('div');
        d.className='col-5';
        d.innerHTML=`<button onclick="checkA(this,'${opt.replace(/'/g,"\\'")}','${correctVal.replace(/'/g,"\\'")}',\`${currentQ.ar}\`,\`${currentQ.uz}\`,\`${currentQ.trans}\`)"
            style="width:100%;min-height:56px;padding:.6rem;border:1.5px solid rgba(201,168,76,.35);border-radius:12px;background:#fff;cursor:pointer;transition:.2s">${optHtml(opt)}</button>`;
        grid.appendChild(d);
    });
}

function checkA(btn,chosen,correct,ar,uz,trans){
    document.querySelectorAll('#optionsGrid button').forEach(b=>b.disabled=true);
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
    const el=document.getElementById('explanation');
    el.innerHTML=`<div class="d-flex align-items-center" style="gap:1.25rem">
        <div style="font-family:'Amiri',serif;font-size:2.5rem;color:var(--green-deep)">${ar}</div>
        <div>
            <div style="font-weight:700">${uz}</div>
            <div style="color:var(--mid-text);font-style:italic">${trans}</div>
        </div>
    </div>`;
    el.style.display='';
    qIdx++;
    setTimeout(nextQ,1600);
}

function showResult(){
    document.getElementById('quizCard').style.display='none';
    document.getElementById('explanation').style.display='none';
    document.getElementById('resultCard').style.display='';
    document.getElementById('finalOk').textContent=scoreOk;
    document.getElementById('finalTotal').textContent=questions.length;
    const pct=Math.round(scoreOk/questions.length*100);
    document.getElementById('resultEmoji').textContent=pct>=90?'🌟':pct>=70?'🎉':pct>=50?'👍':'💪';
    document.getElementById('startBtn').style.display='';
}

function speakWord(text){
    if(!('speechSynthesis' in window))return;
    const u=new SpeechSynthesisUtterance(text);
    u.lang='ar-SA';u.rate=.8;
    speechSynthesis.speak(u);
}
function speakCurrent(){if(currentQ)speakWord(currentQ.ar);}
</script>
