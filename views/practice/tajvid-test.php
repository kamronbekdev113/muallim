<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Tajvid Testi';

$rulesData = [];
foreach ($rules as $r) {
    $rulesData[] = [
        'id'       => $r->id,
        'name'     => $r->name_uz,
        'nameAr'   => $r->name_ar ?? '',
        'category' => $r->category,
        'catLabel' => $r->getCategoryLabel(),
        'color'    => $r->color_code ?? '#888',
        'cssClass' => $r->css_class ?? '',
        'symbol'   => $r->symbol ?? '',
        'desc'     => $r->description_uz ?? '',
        'example'  => $r->example_ar ?? '',
    ];
}
?>
<style>
.rule-learn-card {
    border-radius: 14px;
    padding: 1.25rem;
    border-left: 5px solid;
    background: #fff;
    margin-bottom: 1rem;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    transition: .2s;
}
.rule-learn-card:hover { transform: translateX(3px); }
.rule-ar-example {
    font-family: var(--arabic-font);
    font-size: 1.6rem;
    direction: rtl;
    line-height: 1.8;
}
</style>

<div class="container" style="max-width:860px;padding:2rem 1rem 3rem">
    <div class="d-flex align-items-center mb-3">
        <a href="<?= Url::to(['/mashq']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
            <i class="fas fa-arrow-left mr-1"></i> Mashqlar
        </a>
    </div>

    <div class="section-header">
        <h2>☪️ Tajvid Testi</h2>
        <p>12 tajvid qoidasini o'rganing va quizda sinab ko'ring</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Rang legenda -->
    <div style="background:rgba(74,0,128,.05);border:1px solid rgba(74,0,128,.15);border-radius:12px;padding:1rem 1.25rem;margin-bottom:2rem">
        <div style="font-weight:700;font-size:.85rem;color:#4a0080;margin-bottom:.75rem;text-transform:uppercase;letter-spacing:.05em">Tajvid Ranglari Belgisi</div>
        <div class="d-flex flex-wrap" style="gap:.5rem">
            <?php foreach ($rules as $r): ?>
            <span style="background:<?= $r->color_code ?>22;color:<?= $r->color_code ?>;border:1px solid <?= $r->color_code ?>55;border-radius:20px;padding:3px 10px;font-size:.78rem;font-weight:600">
                <?= Html::encode($r->name_uz) ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Qoidalar o'rganish -->
    <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:1rem">📖 Qoidalarni o'rganish</h5>
    <div class="mb-5">
        <?php foreach ($rules as $r): ?>
        <div class="rule-learn-card" style="border-color:<?= Html::encode($r->color_code ?? '#888') ?>">
            <div class="d-flex align-items-start justify-content-between flex-wrap" style="gap:.5rem;margin-bottom:.6rem">
                <div>
                    <span style="font-weight:800;font-size:1rem;color:<?= Html::encode($r->color_code ?? '#333') ?>"><?= Html::encode($r->name_uz) ?></span>
                    <?php if ($r->name_ar): ?>
                    <span style="font-family:var(--arabic-font);font-size:1.1rem;color:var(--mid-text);margin-right:.5rem"> — <?= $r->name_ar ?></span>
                    <?php endif; ?>
                </div>
                <span style="background:<?= Html::encode($r->color_code ?? '#888') ?>22;color:<?= Html::encode($r->color_code ?? '#888') ?>;border-radius:20px;padding:2px 10px;font-size:.75rem;font-weight:600">
                    <?= Html::encode($r->getCategoryLabel()) ?>
                </span>
            </div>
            <?php if ($r->description_uz): ?>
            <p style="font-size:.88rem;color:var(--dark-text);margin-bottom:.5rem;line-height:1.6"><?= Html::encode($r->description_uz) ?></p>
            <?php endif; ?>
            <?php if ($r->example_ar): ?>
            <div class="rule-ar-example" style="color:<?= Html::encode($r->color_code ?? 'var(--green-deep)') ?>">
                <?= $r->example_ar ?>
            </div>
            <?php endif; ?>
            <?php if ($r->symbol): ?>
            <div style="font-size:.8rem;color:var(--mid-text);margin-top:.4rem">
                <strong>Harflar:</strong> <span style="font-family:var(--arabic-font);font-size:1rem"><?= Html::encode($r->symbol) ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Quiz -->
    <div style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.09);padding:1.75rem">
        <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:.4rem">🧩 Tajvid Quizi</h5>
        <p style="font-size:.88rem;color:var(--mid-text);margin-bottom:1.25rem">Qoidaning nomini yoki tavsifini toping</p>

        <div id="tqMode" class="d-flex mb-3" style="gap:.5rem;flex-wrap:wrap">
            <button onclick="setTQMode('name')" id="tqModeNameBtn" class="btn-muallim" style="font-size:.82rem">Nomini top</button>
            <button onclick="setTQMode('color')" id="tqModeColorBtn" class="btn-muallim-outline" style="font-size:.82rem">Rangdan topish</button>
            <button onclick="setTQMode('cat')" id="tqModeCatBtn" class="btn-muallim-outline" style="font-size:.82rem">Kategoriyani top</button>
        </div>

        <div id="tqQuiz" style="display:none">
            <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;color:var(--mid-text)">
                <span>Savol <span id="tqNum">1</span>/<?= count($rules) ?></span>
                <span>✓ <span id="tqOk" style="color:#28a745;font-weight:600">0</span>  ✗ <span id="tqErr" style="color:#dc3545;font-weight:600">0</span></span>
            </div>
            <div class="progress mb-3" style="height:5px;border-radius:10px">
                <div id="tqBar" class="progress-bar" style="width:0%;background:#4a0080;transition:.3s"></div>
            </div>
            <div id="tqCard" style="text-align:center;padding:1.5rem;background:rgba(74,0,128,.02);border-radius:12px;margin-bottom:1rem">
                <div id="tqQuestion" style="font-size:.9rem;color:var(--mid-text);margin-bottom:.75rem"></div>
                <div id="tqShow" style="margin-bottom:1rem"></div>
                <div id="tqOpts" class="row" style="margin:0;gap:.5rem;justify-content:center"></div>
            </div>
            <div id="tqExpl" style="display:none;padding:.75rem 1rem;background:rgba(74,0,128,.05);border-left:3px solid #4a0080;border-radius:0 8px 8px 0;font-size:.88rem"></div>
        </div>

        <div id="tqResult" style="display:none;text-align:center;padding:1.5rem">
            <div style="font-size:2.5rem;margin-bottom:.5rem">🎓</div>
            <h5>Tugadi! <span id="tqFinalOk" style="color:#28a745"></span>/<?= count($rules) ?></h5>
            <button onclick="startTQ()" class="btn-muallim mt-2">Qayta</button>
        </div>

        <div class="text-center">
            <button onclick="startTQ()" class="btn-gold-fill" id="tqStartBtn">
                <i class="fas fa-play mr-2"></i>Quizni boshlash
            </button>
        </div>
    </div>
</div>

<script>
const RULES = <?= json_encode($rulesData, JSON_UNESCAPED_UNICODE) ?>;
let tqMode='name', tqQs=[], tqIdx=0, tqOk=0, tqErr=0;
function shuffle(a){return a.sort(()=>Math.random()-.5);}
function setTQMode(m){
    tqMode=m;
    ['name','color','cat'].forEach(mm=>{
        document.getElementById('tqMode'+mm.charAt(0).toUpperCase()+mm.slice(1)+'Btn').className=
            m===mm?'btn-muallim':'btn-muallim-outline';
        document.getElementById('tqMode'+mm.charAt(0).toUpperCase()+mm.slice(1)+'Btn').style.fontSize='.82rem';
    });
}
function startTQ(){
    tqQs=shuffle([...RULES]);
    tqIdx=0;tqOk=0;tqErr=0;
    document.getElementById('tqStartBtn').style.display='none';
    document.getElementById('tqResult').style.display='none';
    document.getElementById('tqQuiz').style.display='';
    nextTQ();
}
function nextTQ(){
    if(tqIdx>=tqQs.length){
        document.getElementById('tqQuiz').style.display='none';
        document.getElementById('tqResult').style.display='';
        document.getElementById('tqFinalOk').textContent=tqOk;
        document.getElementById('tqStartBtn').style.display='';
        return;
    }
    const q=tqQs[tqIdx];
    document.getElementById('tqNum').textContent=tqIdx+1;
    document.getElementById('tqBar').style.width=(tqIdx/tqQs.length*100)+'%';
    document.getElementById('tqExpl').style.display='none';

    let qText='', showHtml='', correctVal='';
    const pool=shuffle(RULES.filter(r=>r.id!==q.id)).slice(0,3);
    let opts=[];

    if(tqMode==='name'){
        qText='Bu qoidaning <strong>nomi</strong> nima?';
        showHtml=`<div style="font-size:3rem;font-weight:800;color:${q.color}">${q.example||'◌'}</div>
                  <div style="font-size:.85rem;color:var(--mid-text);margin-top:.4rem">${q.catLabel}</div>`;
        correctVal=q.name;
        opts=shuffle([q,...pool]);
        renderTQOpts(opts, o=>o.name, correctVal, o=>`<div>${o.name}</div>${o.nameAr?`<div style="font-family:'Amiri',serif;font-size:.9rem;color:var(--mid-text)">${o.nameAr}</div>`:''}`);
    } else if(tqMode==='color'){
        qText='Bu rang qaysi tajvid qoidasiga tegishli?';
        showHtml=`<div style="width:80px;height:80px;border-radius:50%;background:${q.color};margin:0 auto;display:flex;align-items:center;justify-content:center">
                    <span style="color:#fff;font-size:.8rem;font-weight:700">${q.cssClass}</span>
                  </div>`;
        correctVal=q.name;
        opts=shuffle([q,...pool]);
        renderTQOpts(opts, o=>o.name, correctVal, o=>`<div style="display:flex;align-items:center;gap:.4rem"><span style="width:12px;height:12px;border-radius:50%;background:${o.color};display:inline-block"></span>${o.name}</div>`);
    } else {
        qText='Bu qoida qaysi <strong>kategoriyaga</strong> kiradi?';
        showHtml=`<div style="font-size:1.3rem;font-weight:800;color:${q.color}">${q.name}</div>
                  ${q.nameAr?`<div style="font-family:'Amiri',serif;font-size:1.4rem;color:var(--mid-text)">${q.nameAr}</div>`:''}`;
        correctVal=q.catLabel;
        const catPool=shuffle([...new Set(RULES.map(r=>r.catLabel))].filter(c=>c!==q.catLabel)).slice(0,3).map(c=>({catLabel:c}));
        opts=shuffle([{catLabel:q.catLabel},...catPool]);
        renderTQOpts(opts, o=>o.catLabel, correctVal, o=>`<div>${o.catLabel}</div>`);
    }
    document.getElementById('tqQuestion').innerHTML=qText;
    document.getElementById('tqShow').innerHTML=showHtml;
}
function renderTQOpts(opts,valFn,correctVal,htmlFn){
    const grid=document.getElementById('tqOpts');
    grid.innerHTML='';
    opts.forEach(o=>{
        const val=valFn(o);
        const d=document.createElement('div');
        d.className='col-5';
        d.innerHTML=`<button onclick="checkTQ(this,'${val.replace(/'/g,"\\'")}','${correctVal.replace(/'/g,"\\'")}',${tqIdx})"
            style="width:100%;min-height:56px;padding:.6rem;border:1.5px solid rgba(74,0,128,.2);border-radius:12px;background:#fff;cursor:pointer;transition:.2s;font-size:.88rem">${htmlFn(o)}</button>`;
        grid.appendChild(d);
    });
}
function checkTQ(btn,chosen,correct,idx){
    if(idx!==tqIdx)return;
    document.querySelectorAll('#tqOpts button').forEach(b=>b.disabled=true);
    const q=tqQs[idx];
    if(chosen===correct){
        btn.style.background='#28a745';btn.style.color='#fff';btn.style.borderColor='#28a745';
        tqOk++;document.getElementById('tqOk').textContent=tqOk;
    } else {
        btn.style.background='#dc3545';btn.style.color='#fff';btn.style.borderColor='#dc3545';
        document.querySelectorAll('#tqOpts button').forEach(b=>{
            const t=b.textContent.trim();
            if(t.includes(correct)||t===correct){b.style.background='#28a745';b.style.color='#fff';b.style.borderColor='#28a745';}
        });
        tqErr++;document.getElementById('tqErr').textContent=tqErr;
    }
    const el=document.getElementById('tqExpl');
    el.innerHTML=`<strong style="color:${q.color}">${q.name}</strong>${q.nameAr?' — <span style="font-family:\'Amiri\',serif">'+q.nameAr+'</span>':''}<br>${q.desc||''}`;
    el.style.display='';
    tqIdx++;
    setTimeout(nextTQ,1800);
}
</script>
