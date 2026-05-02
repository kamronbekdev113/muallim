<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Harflar Bog'lanishi Mashqi";

$lettersData = [];
foreach ($letters as $l) {
    $lettersData[] = [
        'name'  => $l->name_uz,
        'trans' => $l->transliteration,
        'iso'   => $l->isolated,
        'ini'   => $l->initial,
        'med'   => $l->medial,
        'fin'   => $l->final,
    ];
}
?>

<div class="container" style="max-width:860px;padding:2rem 1rem 3rem">
    <a href="<?= Url::to(['/alifbo']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Alifboga qaytish
    </a>

    <div class="section-header mt-2">
        <h2><i class="fas fa-link mr-2" style="color:var(--gold)"></i>Harflar Bog'lanishi</h2>
        <p>Arabcha harflar qanday birikishini, qaysilari birikmasligi va so'z misollarini o'rganing</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Qoida karta -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div style="background:rgba(27,67,50,.06);border:1px solid rgba(27,67,50,.2);border-radius:12px;padding:1.25rem">
                <h6 style="color:var(--green-deep);font-weight:700;margin-bottom:.75rem"><i class="fas fa-arrows-alt-h mr-1"></i> Ikki tomonlama birikuvchi</h6>
                <p style="font-size:.88rem;color:var(--dark-text);margin-bottom:.75rem">
                    Ko'pchilik harflar oldingi va keyingi harfga birikadi. Bunday harflar to'rtta shaklga ega.
                </p>
                <div style="font-family:var(--arabic-font);font-size:1.6rem;color:var(--green-deep);direction:rtl">
                    بِسْمِ → <span style="color:#888">ب + س + م</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div style="background:rgba(139,94,60,.06);border:1px solid rgba(139,94,60,.2);border-radius:12px;padding:1.25rem">
                <h6 style="color:var(--brown,#8B5E3C);font-weight:700;margin-bottom:.75rem"><i class="fas fa-arrow-right mr-1"></i> Bir tomonlama birikuvchi</h6>
                <p style="font-size:.88rem;color:var(--dark-text);margin-bottom:.75rem">
                    6 ta harf faqat chapdan (oldingi) harfga birikadi, o'ng tomoniga <strong>birikmaydi</strong>.
                </p>
                <div style="font-family:var(--arabic-font);font-size:2rem;color:var(--brown,#8B5E3C);letter-spacing:.2rem;direction:rtl">
                    ا و د ذ ر ز
                </div>
            </div>
        </div>
    </div>

    <!-- Bog'lanish demonstratsiyasi -->
    <div style="background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.07);padding:1.5rem;margin-bottom:2rem">
        <h6 style="font-weight:700;color:var(--green-deep);margin-bottom:1rem">🔍 Harfni tanlang — barcha shakllarini ko'ring</h6>
        <div id="letterSelector" class="d-flex flex-wrap" style="gap:.4rem;margin-bottom:1.25rem">
            <?php foreach ($letters as $l): ?>
            <button onclick="selectLetter(<?= $l->sort_order - 1 ?>)"
                    class="letter-sel-btn"
                    style="font-family:var(--arabic-font);font-size:1.4rem;width:44px;height:44px;border-radius:8px;border:1.5px solid rgba(201,168,76,.35);background:rgba(255,255,255,.9);cursor:pointer;transition:.2s"
                    data-idx="<?= $l->sort_order - 1 ?>">
                <?= $l->isolated ?>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- 4 shakl ko'rsatish -->
        <div id="formsDisplay" style="display:none">
            <div class="row text-center">
                <div class="col-3">
                    <div style="font-size:.75rem;color:var(--mid-text);margin-bottom:.4rem">Alohida</div>
                    <div id="fIso" style="font-family:var(--arabic-font);font-size:3rem;color:var(--green-deep);background:rgba(201,168,76,.08);border-radius:12px;padding:.5rem"></div>
                </div>
                <div class="col-3">
                    <div style="font-size:.75rem;color:var(--mid-text);margin-bottom:.4rem">So'z boshida</div>
                    <div id="fIni" style="font-family:var(--arabic-font);font-size:3rem;color:var(--green-deep);background:rgba(201,168,76,.08);border-radius:12px;padding:.5rem"></div>
                </div>
                <div class="col-3">
                    <div style="font-size:.75rem;color:var(--mid-text);margin-bottom:.4rem">O'rtada</div>
                    <div id="fMed" style="font-family:var(--arabic-font);font-size:3rem;color:var(--green-deep);background:rgba(201,168,76,.08);border-radius:12px;padding:.5rem"></div>
                </div>
                <div class="col-3">
                    <div style="font-size:.75rem;color:var(--mid-text);margin-bottom:.4rem">Oxirida</div>
                    <div id="fFin" style="font-family:var(--arabic-font);font-size:3rem;color:var(--green-deep);background:rgba(201,168,76,.08);border-radius:12px;padding:.5rem"></div>
                </div>
            </div>
            <div id="fName" style="text-align:center;margin-top:.75rem;font-weight:700;color:var(--dark-text);font-size:1rem"></div>
            <div id="fNote" style="text-align:center;font-size:.85rem;color:var(--mid-text);margin-top:.25rem"></div>
        </div>
    </div>

    <!-- So'z tarkibini tahlil qilish -->
    <div style="background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.07);padding:1.5rem;margin-bottom:2rem">
        <h6 style="font-weight:700;color:var(--green-deep);margin-bottom:1rem">📝 So'z tarkibini ko'ring</h6>
        <p style="font-size:.88rem;color:var(--mid-text);margin-bottom:1rem">So'zdagi har bir harf uning shakli bilan ko'rsatiladi</p>
        <div class="row" style="gap:.75rem;margin:0">
            <?php
            $exampleWords = [
                ['ar'=>'كِتَاب','trans'=>'kitāb','uz'=>'Kitob'],
                ['ar'=>'بَيْت','trans'=>'bayt','uz'=>'Uy'],
                ['ar'=>'رَبّ','trans'=>'rabb','uz'=>'Rob'],
                ['ar'=>'نُور','trans'=>'nūr','uz'=>'Nur'],
                ['ar'=>'عِلْم','trans'=>'\'ilm','uz'=>'Bilim'],
                ['ar'=>'قَلَم','trans'=>'qalam','uz'=>'Qalam'],
                ['ar'=>'مَدْرَسَة','trans'=>'madrasa','uz'=>'Madrasa'],
                ['ar'=>'سَلَام','trans'=>'salām','uz'=>'Salom'],
            ];
            foreach ($exampleWords as $w):
            ?>
            <div style="background:rgba(248,243,230,.8);border:1px solid rgba(201,168,76,.25);border-radius:10px;padding:.75rem 1rem;cursor:pointer;min-width:120px;text-align:center"
                 onclick="analyzeWord('<?= $w['ar'] ?>', '<?= $w['uz'] ?>', '<?= $w['trans'] ?>')">
                <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--green-deep)"><?= $w['ar'] ?></div>
                <div style="font-size:.75rem;color:var(--mid-text)"><?= $w['uz'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div id="wordAnalysis" style="display:none;margin-top:1.25rem;padding:1rem;background:rgba(248,243,230,.5);border-radius:12px;border:1px solid rgba(201,168,76,.2)">
            <div id="analysisTitle" style="font-weight:700;color:var(--green-deep);margin-bottom:.75rem"></div>
            <div id="analysisContent"></div>
        </div>
    </div>

    <!-- Quiz qismi -->
    <div style="background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.07);padding:1.5rem">
        <h6 style="font-weight:700;color:var(--green-deep);margin-bottom:.5rem">🧩 Bog'lanish Quizi</h6>
        <p style="font-size:.88rem;color:var(--mid-text);margin-bottom:1rem">Harf so'zdagi shaklini aniqlang</p>

        <div id="connQuizCard" style="text-align:center">
            <button onclick="startConnQuiz()" class="btn-gold-fill" id="connStartBtn">
                <i class="fas fa-play mr-2"></i>Quizni boshlash
            </button>
        </div>

        <div id="connQuiz" style="display:none">
            <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;color:var(--mid-text)">
                <span>Savol <span id="cqNum">1</span>/10</span>
                <span>✓ <span id="cqOk" style="color:#28a745;font-weight:600">0</span>  ✗ <span id="cqErr" style="color:#dc3545;font-weight:600">0</span></span>
            </div>
            <div id="cqQuestion" style="text-align:center;font-size:.95rem;color:var(--dark-text);margin-bottom:.75rem"></div>
            <div id="cqWord" style="text-align:center;font-family:var(--arabic-font);font-size:2.5rem;color:var(--green-deep);margin-bottom:1rem;direction:rtl"></div>
            <div id="cqHighlight" style="text-align:center;font-size:.9rem;color:var(--mid-text);margin-bottom:1rem"></div>
            <div id="cqOpts" class="d-flex justify-content-center" style="gap:.75rem;flex-wrap:wrap"></div>
            <div id="cqExpl" style="display:none;margin-top:1rem;padding:.75rem 1rem;background:rgba(248,243,230,.7);border-radius:8px;font-size:.88rem"></div>
        </div>

        <div id="connResult" style="display:none;text-align:center;padding:1.5rem">
            <div style="font-size:2.5rem;margin-bottom:.5rem">🎓</div>
            <h5>Quiz tugadi!</h5>
            <p>Natija: <strong id="crOk" style="color:#28a745"></strong>/10</p>
            <button onclick="startConnQuiz()" class="btn-muallim">Qayta</button>
        </div>
    </div>
</div>

<script>
const LETTERS = <?= json_encode($lettersData, JSON_UNESCAPED_UNICODE) ?>;
const NON_CONN = <?= json_encode($nonConnecting, JSON_UNESCAPED_UNICODE) ?>;

// Letter selector
function selectLetter(idx) {
    document.querySelectorAll('.letter-sel-btn').forEach(b=>b.style.background='rgba(255,255,255,.9)');
    const btn = document.querySelector(`.letter-sel-btn[data-idx="${idx}"]`);
    if(btn) {btn.style.background='rgba(201,168,76,.25)';btn.style.borderColor='var(--gold)';}
    const l = LETTERS[idx];
    if(!l) return;
    document.getElementById('formsDisplay').style.display='';
    document.getElementById('fIso').textContent = l.iso;
    document.getElementById('fIni').textContent = l.ini || l.iso;
    document.getElementById('fMed').textContent = l.med || l.iso;
    document.getElementById('fFin').textContent = l.fin || l.iso;
    document.getElementById('fName').textContent = l.name + ' (' + l.trans + ')';
    const isNC = NON_CONN.includes(l.iso);
    document.getElementById('fNote').textContent = isNC
        ? '⚠️ Bu harf faqat bir tomonlama birikadi (o\'ngga birikmaydi)'
        : '✅ Bu harf ikki tomonlama birikadi';
}

// Word analysis
function analyzeWord(word, uz, trans) {
    document.getElementById('wordAnalysis').style.display='';
    document.getElementById('analysisTitle').innerHTML = `<span style="font-family:'Amiri',serif;font-size:1.8rem">${word}</span> — ${uz} (${trans})`;
    document.getElementById('analysisContent').innerHTML = '<div style="font-size:.85rem;color:var(--mid-text)">Bu so\'zdagi harflar:</div><div style="font-family:\'Amiri\',serif;font-size:2rem;color:var(--green-deep);direction:rtl;margin-top:.5rem;letter-spacing:.3rem">' + word + '</div>';
}

// Connection Quiz
let cqQs=[], cqIdx=0, cqOk=0, cqErr=0;
const FORM_NAMES = ['Alohida','So\'z boshida','O\'rtada','Oxirida'];
const FORM_KEYS  = ['iso','ini','med','fin'];

function shuffle(a){return a.sort(()=>Math.random()-.5);}

function startConnQuiz(){
    document.getElementById('connStartBtn').style.display='none';
    document.getElementById('connResult').style.display='none';
    document.getElementById('connQuiz').style.display='';
    cqQs = shuffle([...LETTERS].filter(l=>l.ini&&l.med&&l.fin)).slice(0,10);
    cqIdx=0;cqOk=0;cqErr=0;
    nextCQ();
}

function nextCQ(){
    if(cqIdx>=10){showCQResult();return;}
    const l=cqQs[cqIdx];
    const formIdx=Math.floor(Math.random()*4);
    const formKey=FORM_KEYS[formIdx];
    const shown=l[formKey]||l.iso;
    document.getElementById('cqNum').textContent=cqIdx+1;
    document.getElementById('cqQuestion').innerHTML=`<strong>${l.name}</strong> (${l.trans}) harfi quyidagi so'zda qaysi shaklda?`;
    document.getElementById('cqWord').textContent=shown;
    document.getElementById('cqHighlight').textContent='(kattaroq ko\'rsatilgan shakl)';
    document.getElementById('cqExpl').style.display='none';

    const opts=shuffle([...FORM_NAMES]);
    document.getElementById('cqOpts').innerHTML='';
    opts.forEach(opt=>{
        const correctOpt=FORM_NAMES[formIdx];
        const btn=document.createElement('button');
        btn.textContent=opt;
        btn.style.cssText='padding:.5rem 1.1rem;border:1.5px solid rgba(201,168,76,.4);border-radius:10px;background:#fff;cursor:pointer;font-size:.9rem;transition:.2s';
        btn.onclick=function(){checkCQ(opt,correctOpt,this,l,formIdx);};
        document.getElementById('cqOpts').appendChild(btn);
    });
    cqQs[cqIdx]._correct=FORM_NAMES[formIdx];
    cqQs[cqIdx]._formIdx=formIdx;
}

function checkCQ(chosen,correct,btn,l,formIdx){
    document.querySelectorAll('#cqOpts button').forEach(b=>b.disabled=true);
    if(chosen===correct){
        btn.style.background='#28a745';btn.style.color='#fff';btn.style.borderColor='#28a745';
        cqOk++;document.getElementById('cqOk').textContent=cqOk;
    } else {
        btn.style.background='#dc3545';btn.style.color='#fff';btn.style.borderColor='#dc3545';
        document.querySelectorAll('#cqOpts button').forEach(b=>{if(b.textContent===correct){b.style.background='#28a745';b.style.color='#fff';b.style.borderColor='#28a745';}});
        cqErr++;document.getElementById('cqErr').textContent=cqErr;
    }
    // Barcha shakllar tushuntirish
    const el=document.getElementById('cqExpl');
    el.innerHTML=`${l.name} harfining shakllari:
        <span style="font-family:'Amiri',serif;font-size:1.4rem"> ${l.iso} </span>(alohida)
        <span style="font-family:'Amiri',serif;font-size:1.4rem"> ${l.ini||l.iso} </span>(boshi)
        <span style="font-family:'Amiri',serif;font-size:1.4rem"> ${l.med||l.iso} </span>(o'rta)
        <span style="font-family:'Amiri',serif;font-size:1.4rem"> ${l.fin||l.iso} </span>(oxiri)`;
    el.style.display='';
    cqIdx++;
    setTimeout(nextCQ,1700);
}

function showCQResult(){
    document.getElementById('connQuiz').style.display='none';
    document.getElementById('connResult').style.display='';
    document.getElementById('crOk').textContent=cqOk;
}
</script>
