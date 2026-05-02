<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Harakat Mashqi';
?>
<style>
.harakat-card {
    background: linear-gradient(135deg, #fff 0%, #f8f5ff 100%);
    border: 2px solid rgba(13,71,161,.15);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
}
.harakat-card:hover, .harakat-card.active {
    border-color: #1976d2;
    box-shadow: 0 6px 20px rgba(13,71,161,.18);
    transform: translateY(-2px);
}
.harakat-symbol {
    font-family: var(--arabic-font);
    font-size: 3rem;
    color: var(--green-deep);
    line-height: 1.6;
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.harakat-name-ar { font-family: var(--arabic-font); font-size: 1.2rem; color: var(--gold-dark); }
.quiz-opt-btn {
    width: 100%; padding: .75rem; border-radius: 12px;
    border: 1.5px solid rgba(13,71,161,.25); background: #fff;
    cursor: pointer; transition: .2s; font-size: .95rem;
    font-family: var(--arabic-font);
}
.quiz-opt-btn:hover { border-color: #1976d2; background: rgba(13,71,161,.04); }
</style>

<div class="container" style="max-width:820px;padding:2rem 1rem 3rem">
    <div class="d-flex align-items-center mb-3" style="gap:1rem">
        <a href="<?= Url::to(['/mashq']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
            <i class="fas fa-arrow-left mr-1"></i> Mashqlar
        </a>
    </div>

    <div class="section-header">
        <h2>◌َ◌ِ◌ُ Harakat Mashqi</h2>
        <p>Arabcha harakatlar (unli belgilar) — o'qish va talaffuz asosi</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Harakat jadvali -->
    <div class="mb-5">
        <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:1.25rem">📖 Barcha harakatlar</h5>
        <div class="row" style="margin:0;gap:.75rem">

            <?php
            $harakats = [
                ['بَ','ba','فتحة','Fatha','a ovozi — harf ustida qiya chiziq','#e65100','rgba(255,152,0,.1)'],
                ['بِ','bi','كسرة','Kasra','i ovozi — harf ostida qiya chiziq','#0d47a1','rgba(13,71,161,.1)'],
                ['بُ','bu','ضمة','Damma','u ovozi — harf ustida halqa','#1b5e20','rgba(27,94,32,.1)'],
                ['بْ','b','سكون','Sukun','unli yo\'q — harf ustida kichik doira','#4a0080','rgba(74,0,128,.1)'],
                ['بّ','bb','شدّة','Shadda','harf ikki marta — to\'lqin belgisi','#8b0000','rgba(139,0,0,.1)'],
                ['بً','ban','تنوين فتح','Tanwin Fath','an — ikki fatha','#e65100','rgba(255,152,0,.1)'],
                ['بٍ','bin','تنوين كسر','Tanwin Kasr','in — ikki kasra','#0d47a1','rgba(13,71,161,.1)'],
                ['بٌ','bun','تنوين ضم','Tanwin Damm','un — ikki damma','#1b5e20','rgba(27,94,32,.1)'],
                ['بَا','bā','مدّ','Madd (alif)','cho\'zilgan a ovozi','#003087','rgba(0,48,135,.1)'],
                ['بِي','bī','مدّ','Madd (ya)','cho\'zilgan i ovozi','#003087','rgba(0,48,135,.1)'],
                ['بُو','bū','مدّ','Madd (vov)','cho\'zilgan u ovozi','#003087','rgba(0,48,135,.1)'],
            ];
            foreach ($harakats as $h):
            ?>
            <div class="harakat-card" style="min-width:120px;flex:1;max-width:160px;background:<?= $h[5] ?>;border-color:<?= str_replace('rgba(','rgba(',$h[4]) ?>">
                <div class="harakat-symbol" style="color:<?= $h[4] ?>"><?= $h[0] ?></div>
                <div style="font-size:1.1rem;font-weight:700;color:<?= $h[4] ?>;margin-bottom:3px"><?= $h[1] ?></div>
                <div class="harakat-name-ar" style="color:<?= $h[4] ?>"><?= $h[2] ?></div>
                <div style="font-weight:600;font-size:.8rem;color:var(--dark-text);margin:4px 0 2px"><?= $h[3] ?></div>
                <div style="font-size:.72rem;color:var(--mid-text);line-height:1.3"><?= $h[4] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Ba jadval — harf × harakat -->
    <div class="mb-5">
        <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:1rem">📊 Harf × Harakat jadval</h5>
        <p style="font-size:.88rem;color:var(--mid-text);margin-bottom:1rem">Bir harfni barcha harakatlarda o'qish</p>
        <?php
        $baseLetters = [
            'ب'=>'b','ت'=>'t','ث'=>'s','ج'=>'j','ح'=>'h',
            'خ'=>'x','د'=>'d','ر'=>'r','س'=>'s','ش'=>'sh',
        ];
        $hSuffixes = [
            ['ـَ','a','fatha'],['ـِ','i','kasra'],['ـُ','u','damma'],['ـْ','','sukun'],
        ];
        ?>
        <div style="overflow-x:auto">
            <table style="border-collapse:collapse;min-width:100%;font-family:var(--arabic-font)">
                <thead>
                    <tr style="background:rgba(27,67,50,.06)">
                        <th style="padding:.6rem .8rem;text-align:right;font-family:var(--ui-font);font-size:.8rem;color:var(--mid-text)">Harf</th>
                        <th style="padding:.6rem .8rem;text-align:center;color:#e65100;font-size:.9rem">ـَ Fatha</th>
                        <th style="padding:.6rem .8rem;text-align:center;color:#0d47a1;font-size:.9rem">ـِ Kasra</th>
                        <th style="padding:.6rem .8rem;text-align:center;color:#1b5e20;font-size:.9rem">ـُ Damma</th>
                        <th style="padding:.6rem .8rem;text-align:center;color:#4a0080;font-size:.9rem">ـْ Sukun</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($baseLetters as $ar => $lat): ?>
                <tr style="border-bottom:1px solid var(--border)">
                    <td style="padding:.6rem .8rem;font-size:1.4rem;color:var(--green-deep);font-weight:600;text-align:right"><?= $ar ?></td>
                    <td style="padding:.6rem .8rem;text-align:center">
                        <div style="font-size:1.8rem;color:#e65100"><?= $ar ?>َ</div>
                        <div style="font-size:.72rem;color:var(--mid-text)"><?= $lat ?>a</div>
                    </td>
                    <td style="padding:.6rem .8rem;text-align:center">
                        <div style="font-size:1.8rem;color:#0d47a1"><?= $ar ?>ِ</div>
                        <div style="font-size:.72rem;color:var(--mid-text)"><?= $lat ?>i</div>
                    </td>
                    <td style="padding:.6rem .8rem;text-align:center">
                        <div style="font-size:1.8rem;color:#1b5e20"><?= $ar ?>ُ</div>
                        <div style="font-size:.72rem;color:var(--mid-text)"><?= $lat ?>u</div>
                    </td>
                    <td style="padding:.6rem .8rem;text-align:center">
                        <div style="font-size:1.8rem;color:#4a0080"><?= $ar ?>ْ</div>
                        <div style="font-size:.72rem;color:var(--mid-text)"><?= $lat ?></div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Harakat Quiz -->
    <div style="background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.08);padding:1.75rem;margin-bottom:2rem">
        <h5 style="color:var(--green-deep);font-weight:700;margin-bottom:.5rem">🧩 Harakat Quizi</h5>
        <p style="font-size:.88rem;color:var(--mid-text);margin-bottom:1.25rem">Ko'rsatilgan belgining nomini toping</p>

        <div id="hqProgress" style="display:none">
            <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;color:var(--mid-text)">
                <span>Savol <span id="hqNum">1</span>/10</span>
                <span>✓ <span id="hqOk" style="color:#28a745;font-weight:600">0</span>  ✗ <span id="hqErr" style="color:#dc3545;font-weight:600">0</span></span>
            </div>
            <div class="progress mb-3" style="height:5px;border-radius:10px">
                <div id="hqBar" class="progress-bar" style="width:0%;background:#1976d2;transition:.3s"></div>
            </div>
            <div id="hqCard" style="text-align:center;padding:1.5rem 0">
                <div id="hqSymbol" style="font-family:var(--arabic-font);font-size:4rem;color:var(--green-deep);margin-bottom:.5rem;line-height:1.4"></div>
                <div id="hqHint" style="font-size:.85rem;color:var(--mid-text);margin-bottom:1.25rem"></div>
                <div id="hqOpts" class="row" style="margin:0;gap:.5rem;justify-content:center"></div>
            </div>
            <div id="hqExpl" style="display:none;padding:.75rem 1rem;background:rgba(13,71,161,.05);border-left:3px solid #1976d2;border-radius:0 8px 8px 0;font-size:.88rem;margin-top:.75rem"></div>
        </div>

        <div id="hqResult" style="display:none;text-align:center;padding:1.5rem">
            <div style="font-size:2.5rem;margin-bottom:.5rem">🎓</div>
            <h5>Tugadi! <span id="hqFinalOk" style="color:#28a745"></span>/10</h5>
            <button onclick="startHQ()" class="btn-muallim mt-2">Qayta</button>
        </div>

        <div class="text-center">
            <button onclick="startHQ()" class="btn-gold-fill" id="hqStartBtn">
                <i class="fas fa-play mr-2"></i>Quizni boshlash
            </button>
        </div>
    </div>
</div>

<script>
const HQ_DATA = [
    {sym:'بَ', hint:'Harf + harakat', name:'Fatha (a)', color:'#e65100', explain:'Fatha — harf USTIDA qiya chiziq. "a" ovozi beradi. Misol: كَ = ka'},
    {sym:'بِ', hint:'Harf + harakat', name:'Kasra (i)', color:'#0d47a1', explain:'Kasra — harf OSTIDA qiya chiziq. "i" ovozi beradi. Misol: بِ = bi'},
    {sym:'بُ', hint:'Harf + harakat', name:'Damma (u)', color:'#1b5e20', explain:'Damma — harf ustida halqa shakl. "u" ovozi beradi. Misol: بُ = bu'},
    {sym:'بْ', hint:'Harf + harakat', name:'Sukun (tovushsiz)', color:'#4a0080', explain:'Sukun — harf ustida kichik doira. Harfdan keyin unli yo\'q. Misol: بْ = b'},
    {sym:'بّ', hint:'Harf + harakat', name:'Shadda (qo\'sh)', color:'#8b0000', explain:'Shadda — to\'lqin belgisi. Harfni ikki marta aytish. Misol: بّ = bb'},
    {sym:'بَا', hint:'Cho\'zilgan tovush', name:'Madd Alif (ā)', color:'#003087', explain:'Madd — cho\'zilgan "ā" (aa). Alif belgisi bilan cho\'ziladi. 2 yoki 4-6 maqom'},
    {sym:'بِي', hint:'Cho\'zilgan tovush', name:'Madd Ya (ī)', color:'#003087', explain:'Madd — cho\'zilgan "ī" (ii). Ya harfi bilan cho\'ziladi'},
    {sym:'بُو', hint:'Cho\'zilgan tovush', name:'Madd Vov (ū)', color:'#003087', explain:'Madd — cho\'zilgan "ū" (uu). Vov harfi bilan cho\'ziladi'},
    {sym:'بً', hint:'So\'z oxiri', name:'Tanwin Fath (an)', color:'#e65100', explain:'Tanwin Fath — ikki fatha. So\'z oxirida "an" ovozi. Misol: كِتَابًا = kitāban'},
    {sym:'بٍ', hint:'So\'z oxiri', name:'Tanwin Kasr (in)', color:'#0d47a1', explain:'Tanwin Kasra — ikki kasra. So\'z oxirida "in" ovozi. Misol: بَيْتٍ = baytin'},
    {sym:'بٌ', hint:'So\'z oxiri', name:'Tanwin Damm (un)', color:'#1b5e20', explain:'Tanwin Damma — ikki damma. So\'z oxirida "un" ovozi. Misol: كِتَابٌ = kitābun'},
];
const ALL_NAMES = HQ_DATA.map(d=>d.name);
let hqQs=[], hqIdx=0, hqOk=0, hqErr=0;
function shuffle(a){return a.sort(()=>Math.random()-.5);}

function startHQ(){
    hqQs=shuffle([...HQ_DATA]).slice(0,10);
    hqIdx=0;hqOk=0;hqErr=0;
    document.getElementById('hqStartBtn').style.display='none';
    document.getElementById('hqResult').style.display='none';
    document.getElementById('hqProgress').style.display='';
    nextHQ();
}
function nextHQ(){
    if(hqIdx>=10){
        document.getElementById('hqProgress').style.display='none';
        document.getElementById('hqResult').style.display='';
        document.getElementById('hqFinalOk').textContent=hqOk;
        document.getElementById('hqStartBtn').style.display='';
        return;
    }
    const q=hqQs[hqIdx];
    document.getElementById('hqNum').textContent=hqIdx+1;
    document.getElementById('hqBar').style.width=(hqIdx/10*100)+'%';
    document.getElementById('hqSymbol').textContent=q.sym;
    document.getElementById('hqSymbol').style.color=q.color;
    document.getElementById('hqHint').textContent=q.hint;
    document.getElementById('hqExpl').style.display='none';

    const wrongs=shuffle(ALL_NAMES.filter(n=>n!==q.name)).slice(0,3);
    const opts=shuffle([q.name,...wrongs]);
    const grid=document.getElementById('hqOpts');
    grid.innerHTML='';
    opts.forEach(o=>{
        const d=document.createElement('div');
        d.className='col-5';
        d.innerHTML=`<button onclick="checkHQ('${o.replace(/'/g,"\\'")}','${q.name.replace(/'/g,"\\'")}',this,\`${q.explain.replace(/`/g,'\\`')}\`)"
            class="quiz-opt-btn">${o}</button>`;
        grid.appendChild(d);
    });
}
function checkHQ(chosen,correct,btn,explain){
    document.querySelectorAll('#hqOpts button').forEach(b=>b.disabled=true);
    if(chosen===correct){
        btn.style.background='#28a745';btn.style.color='#fff';btn.style.borderColor='#28a745';
        hqOk++;document.getElementById('hqOk').textContent=hqOk;
    } else {
        btn.style.background='#dc3545';btn.style.color='#fff';btn.style.borderColor='#dc3545';
        document.querySelectorAll('#hqOpts button').forEach(b=>{if(b.textContent===correct){b.style.background='#28a745';b.style.color='#fff';b.style.borderColor='#28a745';}});
        hqErr++;document.getElementById('hqErr').textContent=hqErr;
    }
    document.getElementById('hqExpl').innerHTML='<i class="fas fa-info-circle mr-1" style="color:#1976d2"></i>'+explain;
    document.getElementById('hqExpl').style.display='';
    hqIdx++;
    setTimeout(nextHQ,1700);
}
</script>
