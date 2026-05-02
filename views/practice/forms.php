<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Harf Shakllari Mashqi';

// JS uchun ma'lumot
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

<div class="container" style="max-width:700px;padding:2rem 1rem 3rem">
    <a href="<?= Url::to(['/alifbo']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Alifboga qaytish
    </a>

    <div class="section-header mt-2">
        <h2><i class="fas fa-shapes mr-2" style="color:var(--gold)"></i>Harf Shakllari Mashqi</h2>
        <p>Arabcha harflar so'zdagi joylashuviga qarab 4 xil shaklda yoziladi</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Ma'lumot kartasi -->
    <div style="background:rgba(201,168,76,.07);border:1px solid rgba(201,168,76,.3);border-radius:12px;padding:1.2rem 1.5rem;margin-bottom:1.5rem">
        <div class="row text-center">
            <div class="col-3">
                <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--green-deep)">ـبـ</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:3px">O'rtada</div>
                <div style="font-size:.7rem;color:var(--light-text)">medial</div>
            </div>
            <div class="col-3">
                <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--green-deep)">بـ</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:3px">Boshida</div>
                <div style="font-size:.7rem;color:var(--light-text)">initial</div>
            </div>
            <div class="col-3">
                <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--green-deep)">ـب</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:3px">Oxirida</div>
                <div style="font-size:.7rem;color:var(--light-text)">final</div>
            </div>
            <div class="col-3">
                <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--green-deep)">ب</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:3px">Alohida</div>
                <div style="font-size:.7rem;color:var(--light-text)">isolated</div>
            </div>
        </div>
    </div>

    <!-- Progress -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div style="font-size:.85rem;color:var(--mid-text)">Savol: <span id="qNum">1</span> / <span id="qTotal">?</span></div>
        <div>
            <span style="color:#28a745;font-weight:600"><i class="fas fa-check"></i> <span id="scoreOk">0</span></span>
            <span style="color:#dc3545;font-weight:600;margin-left:1rem"><i class="fas fa-times"></i> <span id="scoreErr">0</span></span>
        </div>
    </div>
    <div class="progress mb-4" style="height:6px;border-radius:10px">
        <div id="progressBar" class="progress-bar" style="width:0%;background:var(--gold);transition:.3s"></div>
    </div>

    <!-- Quiz kartasi -->
    <div id="quizCard" style="background:#fff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,.08);padding:2rem;text-align:center;min-height:280px">
        <div id="questionLabel" style="font-size:.9rem;color:var(--mid-text);margin-bottom:.75rem"></div>
        <div id="questionArabic" style="font-family:var(--arabic-font);font-size:3.5rem;color:var(--green-deep);line-height:1.3;margin-bottom:.5rem"></div>
        <div id="questionMeta" style="font-size:.85rem;color:var(--light-text);margin-bottom:1.5rem"></div>
        <div id="optionsGrid" class="row" style="gap:.5rem;justify-content:center;margin:0"></div>
    </div>

    <!-- Tushuntirish -->
    <div id="explanation" style="display:none;margin-top:1rem;padding:1rem 1.25rem;background:rgba(27,67,50,.05);border-left:4px solid var(--green-deep);border-radius:0 8px 8px 0;font-size:.9rem"></div>

    <!-- Natija -->
    <div id="resultCard" style="display:none;text-align:center;padding:2.5rem">
        <div style="font-size:3rem;margin-bottom:.5rem">🎉</div>
        <h3>Mashq tugadi!</h3>
        <p>To'g'ri: <strong id="finalOk" style="color:#28a745"></strong> / <span id="finalTotal"></span></p>
        <div class="d-flex justify-content-center mt-3" style="gap:1rem">
            <button onclick="startQuiz()" class="btn-muallim">Qayta boshlash</button>
            <a href="<?= Url::to(['/mashq/talaffuz']) ?>" class="btn-muallim-outline">Keyingi mashq →</a>
        </div>
    </div>

    <!-- Boshqarish -->
    <div class="text-center mt-4">
        <button onclick="startQuiz()" class="btn-gold-fill" id="startBtn">
            <i class="fas fa-play mr-2"></i>Boshlash
        </button>
    </div>
</div>

<script>
const LETTERS = <?= json_encode($lettersData, JSON_UNESCAPED_UNICODE) ?>;
const FORM_NAMES = { iso:'Alohida (isolated)', ini:'So\'z boshi (initial)', med:'O\'rta (medial)', fin:'So\'z oxiri (final)' };
const FORM_LABELS = { iso:'Alohida', ini:'So\'z boshi', med:'O\'rtada', fin:'Oxirida' };
let questions = [], qIdx = 0, scoreOk = 0, scoreErr = 0;

function shuffle(arr) { return arr.sort(()=>Math.random()-.5); }

function startQuiz() {
    questions = [];
    LETTERS.forEach(l => {
        ['iso','ini','med','fin'].forEach(form => {
            if(l[form]) questions.push({ letter:l, correctForm:form });
        });
    });
    questions = shuffle(questions).slice(0, 20);
    qIdx = 0; scoreOk = 0; scoreErr = 0;
    document.getElementById('qTotal').textContent = questions.length;
    document.getElementById('startBtn').style.display = 'none';
    document.getElementById('resultCard').style.display = 'none';
    document.getElementById('quizCard').style.display = '';
    nextQuestion();
}

function nextQuestion() {
    if (qIdx >= questions.length) { showResult(); return; }
    const q = questions[qIdx];
    document.getElementById('qNum').textContent = qIdx + 1;
    document.getElementById('progressBar').style.width = (qIdx/questions.length*100)+'%';
    document.getElementById('explanation').style.display = 'none';

    // Savol: harf tasodifiy shaklda ko'rsatiladi
    const showForm = q.correctForm;
    document.getElementById('questionLabel').innerHTML = `<strong>${q.letter.name}</strong> (${q.letter.trans}) harfi quyida qaysi shaklda ko'rsatilgan?`;
    document.getElementById('questionArabic').textContent = q.letter[showForm];
    document.getElementById('questionMeta').textContent = '';

    // 4 variant
    const opts = shuffle(['iso','ini','med','fin']);
    const grid = document.getElementById('optionsGrid');
    grid.innerHTML = '';
    opts.forEach(form => {
        const btn = document.createElement('div');
        btn.className = 'col-5';
        btn.innerHTML = `<button onclick="checkAnswer('${form}','${q.correctForm}', this)" class="btn btn-outline-secondary w-100" style="padding:.65rem;font-size:.9rem;border-radius:10px">${FORM_LABELS[form]}</button>`;
        grid.appendChild(btn);
    });
}

function checkAnswer(chosen, correct, btn) {
    const allBtns = document.querySelectorAll('#optionsGrid button');
    allBtns.forEach(b => b.disabled = true);
    const q = questions[qIdx];
    if (chosen === correct) {
        btn.style.background = '#28a745'; btn.style.color = '#fff'; btn.style.borderColor = '#28a745';
        scoreOk++;
        document.getElementById('scoreOk').textContent = scoreOk;
        showExplanation(q, correct, true);
    } else {
        btn.style.background = '#dc3545'; btn.style.color = '#fff'; btn.style.borderColor = '#dc3545';
        // To'g'ri javobni ko'rsatish
        allBtns.forEach(b => { if(b.textContent.trim() === FORM_LABELS[correct]) { b.style.background='#28a745';b.style.color='#fff';b.style.borderColor='#28a745'; }});
        scoreErr++;
        document.getElementById('scoreErr').textContent = scoreErr;
        showExplanation(q, correct, false);
    }
    qIdx++;
    setTimeout(nextQuestion, 1500);
}

function showExplanation(q, form, correct) {
    const el = document.getElementById('explanation');
    const forms = ['iso','ini','med','fin'];
    let html = `<strong>${q.letter.name_uz} harfining barcha shakllari:</strong><div class="d-flex mt-2" style="gap:1.5rem;flex-wrap:wrap">`;
    forms.forEach(f => {
        html += `<div style="text-align:center"><div style="font-family:'Amiri',serif;font-size:2rem;color:var(--green-deep)">${q.letter[f] || q.letter.iso || '—'}</div><div style="font-size:.72rem;color:var(--mid-text)">${FORM_LABELS[f]}</div></div>`;
    });
    html += '</div>';
    el.innerHTML = (correct ? '✅ ' : '❌ ') + html;
    el.style.display = '';
}

function showResult() {
    document.getElementById('quizCard').style.display = 'none';
    document.getElementById('explanation').style.display = 'none';
    document.getElementById('resultCard').style.display = '';
    document.getElementById('finalOk').textContent = scoreOk;
    document.getElementById('finalTotal').textContent = questions.length;
    document.getElementById('startBtn').style.display = '';
}
</script>
