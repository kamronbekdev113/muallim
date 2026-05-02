<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Xotira O\'yini';

// Build card data: each letter gets one "arabic" card + one "name" card
$pairs = [];
foreach ($letters as $l) {
    $pairs[] = [
        'id'     => $l->id,
        'arabic' => $l->letter,
        'name'   => $l->name_uz,
        'trans'  => $l->transliteration,
    ];
}
?>
<style>
.memory-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: .75rem;
}
.mem-card {
    height: 90px;
    perspective: 600px;
    cursor: pointer;
}
.mem-inner {
    width: 100%; height: 100%;
    position: relative;
    transform-style: preserve-3d;
    transition: transform .4s;
    border-radius: 12px;
}
.mem-card.flipped .mem-inner { transform: rotateY(180deg); }
.mem-card.matched .mem-inner { transform: rotateY(180deg); }
.mem-face {
    position: absolute; inset: 0;
    backface-visibility: hidden;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid var(--border);
    font-weight: 700;
    user-select: none;
}
.mem-front {
    background: var(--green-deep);
    color: var(--gold);
    font-family: var(--arabic-font);
    font-size: 1.8rem;
}
.mem-back {
    transform: rotateY(180deg);
    background: var(--card-bg);
    flex-direction: column;
    gap: .15rem;
}
.mem-back .ar { font-family: var(--arabic-font); font-size: 1.6rem; color: var(--green-deep); }
.mem-back .nm { font-size: .72rem; color: var(--mid-text); font-weight: 600; }
.mem-card.matched .mem-face {
    border-color: #28a745;
    box-shadow: 0 0 0 2px #28a74544;
}
.mem-card.wrong .mem-inner { animation: shake .35s; }
@keyframes shake {
    0%,100%{ transform: rotateY(180deg) translateX(0); }
    25%    { transform: rotateY(180deg) translateX(-6px); }
    75%    { transform: rotateY(180deg) translateX(6px); }
}
</style>

<div class="container" style="max-width:900px;padding:2rem 1rem 3rem">
    <div class="d-flex align-items-center mb-3">
        <a href="<?= Url::to(['/mashq']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
            <i class="fas fa-arrow-left mr-1"></i> Mashqlar
        </a>
    </div>

    <div class="section-header">
        <h2>🃏 Xotira O'yini</h2>
        <p>Arab harfi bilan uning nomini juftlashtiring</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Controls -->
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3" style="gap:.75rem">
        <div class="d-flex" style="gap:.5rem;flex-wrap:wrap">
            <button onclick="startGame(8)"  id="sz8"  class="btn-muallim" style="font-size:.82rem">8 juft</button>
            <button onclick="startGame(14)" id="sz14" class="btn-muallim-outline" style="font-size:.82rem">14 juft</button>
            <button onclick="startGame(28)" id="sz28" class="btn-muallim-outline" style="font-size:.82rem">28 juft</button>
        </div>
        <div style="font-size:.88rem;color:var(--mid-text)">
            Urinish: <strong id="movesEl">0</strong> &nbsp;|&nbsp;
            Juftlar: <strong id="matchEl" style="color:#28a745">0</strong>/<span id="totalEl">?</span>
        </div>
    </div>

    <!-- Timer -->
    <div style="font-size:1rem;color:var(--gold);font-weight:700;text-align:right;margin-bottom:.5rem" id="timerEl"></div>

    <!-- Grid -->
    <div class="memory-grid" id="memGrid"></div>

    <!-- Result -->
    <div id="memResult" style="display:none;text-align:center;margin-top:2rem;padding:2rem;background:var(--card-bg);border-radius:16px;border:1px solid var(--border)">
        <div style="font-size:2.5rem">🎉</div>
        <h5 style="color:var(--green-deep);font-weight:700;margin:.5rem 0">Barakalla! Barcha juftlar topildi!</h5>
        <p style="color:var(--mid-text)" id="resultStats"></p>
        <button onclick="startGame(currentSize)" class="btn-gold-fill mt-2">Qayta o'ynash</button>
    </div>
</div>

<script>
const PAIRS = <?= json_encode($pairs, JSON_UNESCAPED_UNICODE) ?>;
let flipped=[], matched=[], moves=0, timer=null, seconds=0, currentSize=8, locked=false;

function startGame(n) {
    currentSize = n;
    ['8','14','28'].forEach(s => {
        document.getElementById('sz'+s).className = (+s===n) ? 'btn-muallim' : 'btn-muallim-outline';
        document.getElementById('sz'+s).style.fontSize = '.82rem';
    });
    // pick n random pairs
    const pool = [...PAIRS].sort(()=>Math.random()-.5).slice(0, n);
    // create card objects: arabic card + name card per pair
    let cards = [];
    pool.forEach(p => {
        cards.push({uid: p.id+'_ar', pairId: p.id, type:'arabic', ar: p.arabic, name: p.name, trans: p.trans});
        cards.push({uid: p.id+'_nm', pairId: p.id, type:'name',   ar: p.arabic, name: p.name, trans: p.trans});
    });
    cards.sort(()=>Math.random()-.5);

    flipped=[]; matched=[]; moves=0; locked=false;
    document.getElementById('movesEl').textContent='0';
    document.getElementById('matchEl').textContent='0';
    document.getElementById('totalEl').textContent=n;
    document.getElementById('memResult').style.display='none';

    // timer
    clearInterval(timer); seconds=0;
    document.getElementById('timerEl').textContent='00:00';
    timer = setInterval(()=>{
        seconds++;
        var m=Math.floor(seconds/60), s=seconds%60;
        document.getElementById('timerEl').textContent=(m<10?'0':'')+m+':'+(s<10?'0':'')+s;
    },1000);

    const grid = document.getElementById('memGrid');
    grid.innerHTML='';
    cards.forEach(c=>{
        const div = document.createElement('div');
        div.className='mem-card';
        div.dataset.uid=c.uid;
        div.dataset.pairId=c.pairId;
        div.dataset.type=c.type;
        if(c.type==='arabic'){
            div.innerHTML=`<div class="mem-inner">
                <div class="mem-face mem-front">?</div>
                <div class="mem-face mem-back"><span class="ar">${c.ar}</span></div>
            </div>`;
        } else {
            div.innerHTML=`<div class="mem-inner">
                <div class="mem-face mem-front">?</div>
                <div class="mem-face mem-back"><span class="nm">${c.name}</span><span style="font-size:.65rem;color:var(--light-text)">${c.trans}</span></div>
            </div>`;
        }
        div.addEventListener('click',()=>flipCard(div,c));
        grid.appendChild(div);
    });
}

function flipCard(div, c){
    if(locked) return;
    if(div.classList.contains('flipped')||div.classList.contains('matched')) return;
    div.classList.add('flipped');
    flipped.push({el:div,c});
    if(flipped.length===2){
        locked=true; moves++;
        document.getElementById('movesEl').textContent=moves;
        checkMatch();
    }
}

function checkMatch(){
    const [a,b]=flipped;
    if(a.c.pairId===b.c.pairId && a.c.type!==b.c.type){
        // match!
        setTimeout(()=>{
            a.el.classList.add('matched');
            b.el.classList.add('matched');
            matched.push(a.c.pairId);
            document.getElementById('matchEl').textContent=matched.length;
            flipped=[]; locked=false;
            if(matched.length===currentSize){
                clearInterval(timer);
                document.getElementById('memResult').style.display='';
                var m=Math.floor(seconds/60), s=seconds%60;
                document.getElementById('resultStats').textContent=
                    moves+' urinishda, '+(m<10?'0':'')+m+':'+(s<10?'0':'')+s+' ichida topildi!';
            }
        },400);
    } else {
        // wrong
        a.el.classList.add('wrong');
        b.el.classList.add('wrong');
        setTimeout(()=>{
            a.el.classList.remove('flipped','wrong');
            b.el.classList.remove('flipped','wrong');
            flipped=[]; locked=false;
        },900);
    }
}
startGame(8);
</script>
