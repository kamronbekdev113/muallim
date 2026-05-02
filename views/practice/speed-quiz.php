<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Tez Quiz';

$letData = [];
foreach ($letters as $l) {
    $letData[] = [
        'id'    => $l->id,
        'ar'    => $l->letter,
        'name'  => $l->name_uz,
        'trans' => $l->transliteration,
        'iso'   => $l->isolated,
        'ini'   => $l->initial,
        'med'   => $l->medial,
        'fin'   => $l->final,
    ];
}
?>
<style>
.speed-question {
    font-family: var(--arabic-font);
    font-size: 5rem;
    color: var(--green-deep);
    text-align: center;
    line-height: 1.2;
    margin: 1rem 0;
    min-height: 7rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.speed-opts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .75rem;
    margin-top: 1rem;
}
.speed-opt-btn {
    padding: .75rem;
    border-radius: 12px;
    border: 2px solid var(--border);
    background: var(--card-bg);
    cursor: pointer;
    font-size: .92rem;
    font-weight: 600;
    color: var(--dark-text);
    transition: .15s;
    text-align: center;
}
.speed-opt-btn:hover:not(:disabled) { border-color: var(--gold); background: rgba(201,168,76,.08); }
.speed-opt-btn.correct { background:#28a745!important; color:#fff!important; border-color:#28a745!important; }
.speed-opt-btn.wrong   { background:#dc3545!important; color:#fff!important; border-color:#dc3545!important; }
.speed-timer-bar {
    height: 8px;
    border-radius: 4px;
    background: var(--parchment-dark);
    overflow: hidden;
    margin-bottom: 1rem;
}
.speed-timer-fill {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(90deg, #28a745, var(--gold), #dc3545);
    transition: width .1s linear;
}
</style>

<div class="container" style="max-width:640px;padding:2rem 1rem 3rem">
    <div class="d-flex align-items-center mb-3">
        <a href="<?= Url::to(['/mashq']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
            <i class="fas fa-arrow-left mr-1"></i> Mashqlar
        </a>
    </div>

    <div class="section-header">
        <h2>⚡ Tez Quiz</h2>
        <p>60 soniya ichida iloji boricha ko'p savol javob bering!</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Start screen -->
    <div id="startScreen" style="text-align:center;padding:2rem">
        <div style="font-size:3rem;margin-bottom:1rem">⏱️</div>
        <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:.5rem">Qoidalar</h5>
        <p style="color:var(--mid-text);font-size:.9rem">Har savol uchun 1 urinish. To'g'ri javob — +1 ball. Noto'g'ri — -0 ball (vaqt yo'qoladi).</p>
        <div class="d-flex justify-content-center mb-3" style="gap:.5rem;flex-wrap:wrap">
            <button onclick="setMode('name')" id="modeNameBtn" class="btn-muallim" style="font-size:.82rem">Nomini top</button>
            <button onclick="setMode('letter')" id="modeLetterBtn" class="btn-muallim-outline" style="font-size:.82rem">Harfni top</button>
            <button onclick="setMode('trans')" id="modeTransBtn" class="btn-muallim-outline" style="font-size:.82rem">Transkripsiyani top</button>
        </div>
        <button onclick="startGame()" class="btn-gold-fill" style="font-size:1rem;padding:.75rem 2.5rem">
            <i class="fas fa-play mr-2"></i>Boshlash
        </button>
    </div>

    <!-- Game screen -->
    <div id="gameScreen" style="display:none">
        <div class="d-flex justify-content-between align-items-center mb-2" style="font-size:.9rem">
            <span style="color:var(--mid-text)">Savol <strong id="qNum">1</strong></span>
            <span>✓ <strong id="scoreEl" style="color:#28a745">0</strong>  &nbsp; ⏱️ <strong id="timeEl" style="color:var(--gold)">60</strong>s</span>
        </div>
        <div class="speed-timer-bar">
            <div class="speed-timer-fill" id="timerFill" style="width:100%"></div>
        </div>
        <div style="font-size:.82rem;color:var(--mid-text);text-align:center;margin-bottom:.25rem" id="questionLabel"></div>
        <div class="speed-question" id="questionDisplay"></div>
        <div class="speed-opts" id="optsGrid"></div>
        <div id="feedbackBar" style="height:28px;text-align:center;font-size:.88rem;font-weight:600;margin-top:.5rem"></div>
    </div>

    <!-- Result screen -->
    <div id="resultScreen" style="display:none;text-align:center;padding:2rem;background:var(--card-bg);border-radius:16px;border:1px solid var(--border)">
        <div style="font-size:3rem" id="resultEmoji">🏆</div>
        <h4 style="color:var(--green-deep);font-weight:800;margin:.5rem 0" id="resultScore"></h4>
        <p style="color:var(--mid-text)" id="resultMsg"></p>
        <button onclick="showStart()" class="btn-gold-fill mt-2">Qayta urinish</button>
    </div>
</div>

<script>
const LETTERS = <?= json_encode($letData, JSON_UNESCAPED_UNICODE) ?>;
let gameMode='name', timeLeft=60, score=0, qNum=0, timer=null, answered=false;

function setMode(m){
    gameMode=m;
    ['name','letter','trans'].forEach(mm=>{
        const btn=document.getElementById('mode'+mm.charAt(0).toUpperCase()+mm.slice(1)+'Btn');
        btn.className=m===mm?'btn-muallim':'btn-muallim-outline';
        btn.style.fontSize='.82rem';
    });
}
function showStart(){
    document.getElementById('startScreen').style.display='';
    document.getElementById('gameScreen').style.display='none';
    document.getElementById('resultScreen').style.display='none';
    clearInterval(timer);
}
function startGame(){
    score=0; qNum=0; timeLeft=60; answered=false;
    document.getElementById('startScreen').style.display='none';
    document.getElementById('resultScreen').style.display='none';
    document.getElementById('gameScreen').style.display='';
    document.getElementById('scoreEl').textContent='0';
    document.getElementById('timerFill').style.width='100%';
    clearInterval(timer);
    timer=setInterval(()=>{
        timeLeft--;
        document.getElementById('timeEl').textContent=timeLeft;
        document.getElementById('timerFill').style.width=(timeLeft/60*100)+'%';
        if(timeLeft<=0){ clearInterval(timer); endGame(); }
    },1000);
    nextQuestion();
}
function nextQuestion(){
    if(timeLeft<=0) return;
    answered=false;
    qNum++;
    document.getElementById('qNum').textContent=qNum;
    document.getElementById('feedbackBar').textContent='';

    const correct=LETTERS[Math.floor(Math.random()*LETTERS.length)];
    const pool=LETTERS.filter(l=>l.id!==correct.id).sort(()=>Math.random()-.5).slice(0,3);
    const opts=[correct,...pool].sort(()=>Math.random()-.5);

    let qLabel='', qDisplay='', correctVal='', optLabel=(o)=>'';
    if(gameMode==='name'){
        qLabel='Bu harfning nomi nima?';
        qDisplay=`<span style="font-family:var(--arabic-font);font-size:5rem">${correct.ar}</span>`;
        correctVal=correct.name;
        optLabel=o=>`${o.name} <span style="font-size:.75rem;color:var(--mid-text)">(${o.trans})</span>`;
    } else if(gameMode==='letter'){
        qLabel='Bu ism qaysi harfga tegishli?';
        qDisplay=`<span style="font-size:2.2rem;font-weight:800;color:var(--green-deep)">${correct.name}</span><br><span style="font-size:1.1rem;color:var(--mid-text)">${correct.trans}</span>`;
        correctVal=correct.ar;
        optLabel=o=>`<span style="font-family:var(--arabic-font);font-size:2rem">${o.ar}</span>`;
    } else {
        qLabel='Bu harfni qanday talaffuz qilinadi?';
        qDisplay=`<span style="font-family:var(--arabic-font);font-size:5rem">${correct.ar}</span>`;
        correctVal=correct.trans;
        optLabel=o=>o.trans;
    }

    document.getElementById('questionLabel').innerHTML=qLabel;
    document.getElementById('questionDisplay').innerHTML=qDisplay;

    const grid=document.getElementById('optsGrid');
    grid.innerHTML='';
    opts.forEach(o=>{
        const val= gameMode==='name'?o.name: gameMode==='letter'?o.ar: o.trans;
        const btn=document.createElement('button');
        btn.className='speed-opt-btn';
        btn.innerHTML=optLabel(o);
        btn.onclick=()=>checkAnswer(btn,val,correctVal,grid);
        grid.appendChild(btn);
    });
}
function checkAnswer(btn,chosen,correct,grid){
    if(answered) return;
    answered=true;
    Array.from(grid.querySelectorAll('.speed-opt-btn')).forEach(b=>b.disabled=true);
    if(chosen===correct){
        btn.classList.add('correct');
        score++;
        document.getElementById('scoreEl').textContent=score;
        document.getElementById('feedbackBar').innerHTML='<span style="color:#28a745">✓ To\'g\'ri!</span>';
    } else {
        btn.classList.add('wrong');
        // show correct
        Array.from(grid.querySelectorAll('.speed-opt-btn')).forEach(b=>{
            if(b.textContent.trim().includes(correct)||b.innerHTML.includes(correct)) b.classList.add('correct');
        });
        document.getElementById('feedbackBar').innerHTML='<span style="color:#dc3545">✗ Noto\'g\'ri</span>';
    }
    setTimeout(nextQuestion, 700);
}
function endGame(){
    document.getElementById('gameScreen').style.display='none';
    document.getElementById('resultScreen').style.display='';
    document.getElementById('resultScore').textContent=score+' ball / '+qNum+' savol';
    const pct=qNum>0?Math.round(score/qNum*100):0;
    let emoji='🎓', msg='';
    if(pct>=80){ emoji='🏆'; msg='Ajoyib natija! Siz haqiqiy Muallim sifatidayapsiz!'; }
    else if(pct>=60){ emoji='⭐'; msg='Yaxshi! Ozgina mashq qilsangiz mukammal bo\'lasiz.'; }
    else if(pct>=40){ emoji='📚'; msg='Davom eting, harflarni ko\'proq o\'rganing!'; }
    else { emoji='💪'; msg='Boshlang\'ich daraja. Ko\'proq mashq qiling!'; }
    document.getElementById('resultEmoji').textContent=emoji;
    document.getElementById('resultMsg').textContent=msg;
}
</script>
