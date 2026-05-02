<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Gapirish Mashqi';

$letData = [];
foreach ($letters as $l) {
    $letData[] = [
        'id'    => $l->id,
        'ar'    => $l->letter,
        'name'  => $l->name_uz,
        'trans' => $l->transliteration,
        'iso'   => $l->isolated,
    ];
}
?>
<style>
.speak-hero {
    background: linear-gradient(150deg, #0d2a1e 0%, #1b4332 50%, #204d38 100%);
    padding: 2.5rem 1rem 3.5rem;
    text-align: center;
    position: relative; overflow: hidden;
}
.speak-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='%23C9A84C' stroke-width='0.4' opacity='0.15'%3E%3Cpolygon points='40,4 50,18 66,18 55,29 59,44 40,35 21,44 25,29 14,18 30,18'/%3E%3Ccircle cx='40' cy='40' r='22'/%3E%3C/g%3E%3C/svg%3E");
    background-size: 80px;
}
.speak-main-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 24px;
    box-shadow: 0 8px 40px var(--shadow);
    overflow: hidden;
}
.speak-display-area {
    background: linear-gradient(135deg, var(--parchment-dark), var(--parchment));
    padding: 2rem 1.5rem 1.5rem;
    text-align: center;
    border-bottom: 1px solid var(--border);
    position: relative;
}
[data-theme="dark"] .speak-display-area {
    background: linear-gradient(135deg, #0f1a14, #1a2e20);
}
.speak-letter-big {
    font-family: var(--arabic-font);
    font-size: 7rem;
    color: var(--green-deep);
    line-height: 1;
    margin: .25rem 0 .5rem;
    text-shadow: 0 4px 20px rgba(27,67,50,.15);
    transition: all .3s ease;
}
[data-theme="dark"] .speak-letter-big { color: var(--gold); }
.speak-letter-name {
    font-size: 1.5rem; font-weight: 800;
    color: var(--dark-text); margin-bottom: .2rem;
}
.speak-letter-trans {
    color: var(--mid-text); font-style: italic; font-size: 1rem;
}
.speak-controls {
    padding: 1.5rem;
    display: flex; flex-direction: column; align-items: center; gap: 1.25rem;
}
/* Mic button with ring animation */
.mic-center { position: relative; display: inline-flex; align-items: center; justify-content: center; margin: .5rem 0; }
.mic-ring-1, .mic-ring-2, .mic-ring-3 {
    position: absolute; border-radius: 50%;
    border: 2px solid rgba(220,53,69,.35);
    pointer-events: none;
    opacity: 0;
}
.mic-ring-1 { inset: -10px; }
.mic-ring-2 { inset: -22px; }
.mic-ring-3 { inset: -34px; }
.mic-active .mic-ring-1 { animation: micRing 1.2s ease-out infinite; }
.mic-active .mic-ring-2 { animation: micRing 1.2s ease-out .35s infinite; }
.mic-active .mic-ring-3 { animation: micRing 1.2s ease-out .7s infinite; }
@keyframes micRing {
    0%   { opacity:.6; transform: scale(1); }
    100% { opacity:0;  transform: scale(1.25); }
}
.mic-btn-main {
    width: 96px; height: 96px; border-radius: 50%;
    background: linear-gradient(135deg, var(--green-deep), #2D6A4F);
    border: 3px solid rgba(201,168,76,.3);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; color: #fff;
    box-shadow: 0 8px 32px rgba(27,67,50,.4);
    transition: .2s; position: relative; z-index: 1;
}
.mic-btn-main:hover:not(:disabled) { transform: scale(1.06); box-shadow: 0 10px 40px rgba(27,67,50,.5); }
.mic-btn-main:disabled { opacity: .45; cursor: not-allowed; }
.mic-active .mic-btn-main {
    background: linear-gradient(135deg, #c0392b, #dc3545);
    border-color: rgba(220,53,69,.4);
    box-shadow: 0 8px 32px rgba(220,53,69,.35);
}
/* Waveform animation */
.waveform-row {
    display: flex; align-items: center; gap: 3px; height: 44px;
    justify-content: center; min-width: 80px;
}
.wave-bar {
    width: 4px; background: var(--gold); border-radius: 3px;
    height: 5px;
    animation: waveOff .9s ease-in-out infinite;
    transform-origin: center;
}
.wave-bar:nth-child(2) { animation-delay: .12s; }
.wave-bar:nth-child(3) { animation-delay: .24s; }
.wave-bar:nth-child(4) { animation-delay: .12s; }
.wave-bar:nth-child(5) { animation-delay: 0s; }
@keyframes waveOff { 0%,100%{height:5px;} 50%{height:6px;} }
.mic-active .wave-bar { animation: waveOn .9s ease-in-out infinite; }
.mic-active .wave-bar:nth-child(2) { animation-delay:.12s; }
.mic-active .wave-bar:nth-child(3) { animation-delay:.24s; }
.mic-active .wave-bar:nth-child(4) { animation-delay:.12s; }
@keyframes waveOn { 0%,100%{height:6px;} 50%{height:34px;} }
/* Heard text */
.heard-display {
    background: var(--parchment-dark);
    border: 1.5px solid var(--border);
    border-radius: 12px; padding: .6rem 1.25rem;
    text-align: center; font-size: .9rem;
    color: var(--dark-text); font-family: var(--arabic-font);
    font-size: 1.15rem; direction: rtl;
    min-height: 44px; width: 100%;
    transition: border-color .2s;
}
[data-theme="dark"] .heard-display { background: #1a2a3a; }
/* Score display */
.score-wrap { text-align: center; }
.score-circle-big {
    width: 90px; height: 90px; border-radius: 50%;
    border: 4px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; font-weight: 900;
    margin: 0 auto .4rem;
    transition: all .45s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 4px 20px rgba(0,0,0,.1);
}
.score-label { font-size: .8rem; color: var(--mid-text); }
/* Side action buttons */
.speak-actions { display: flex; gap: .75rem; justify-content: center; flex-wrap: wrap; }
/* Session bar */
.session-bar-wrap { width: 100%; }
.session-bar-track {
    height: 8px; border-radius: 4px;
    background: var(--parchment-dark); overflow: hidden;
    margin-top: .3rem;
}
.session-bar-fill { height: 100%; border-radius: 4px; transition: width .5s ease, background .3s; }
/* History */
.speak-history { max-height: 220px; overflow-y: auto; display: flex; flex-direction: column; gap: .4rem; }
.speak-history::-webkit-scrollbar { width: 3px; }
.speak-history::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
.hist-row {
    display: flex; align-items: center; gap: .6rem;
    padding: .4rem .9rem; border-radius: 10px;
    background: var(--card-bg); border: 1px solid var(--border);
    font-size: .82rem;
}
.hist-ar { font-family: var(--arabic-font); font-size: 1.3rem; color: var(--green-deep); min-width: 36px; text-align: center; }
[data-theme="dark"] .hist-ar { color: var(--gold); }
.hist-name { font-weight: 700; min-width: 70px; color: var(--dark-text); }
.hist-heard { flex: 1; color: var(--light-text); font-style: italic; font-size: .75rem; text-align: right; direction: rtl; }
.hist-pct { font-weight: 800; min-width: 44px; text-align: right; }
/* Status text */
.speak-status-txt { font-size: .88rem; color: var(--mid-text); text-align: center; min-height: 22px; transition: color .2s; }
/* No speech */
.no-speech-alert {
    background: rgba(255,193,7,.1); border: 1px solid rgba(255,193,7,.35);
    border-radius: 12px; padding: .75rem 1.1rem; font-size: .84rem;
    color: #856404; margin-bottom: 1rem; display: none;
}
</style>

<!-- Hero -->
<div class="speak-hero">
    <div class="position-relative">
        <div style="font-family:var(--arabic-font);font-size:1.5rem;color:rgba(201,168,76,.7);margin-bottom:.3rem">تَدَرَّبْ عَلَى النُّطْقِ</div>
        <h1 style="color:#fff;font-weight:800;font-size:1.7rem;margin-bottom:.35rem">🎤 Gapirish Mashqi</h1>
        <p style="color:rgba(255,255,255,.72);font-size:.9rem;margin:0">Arabcha harflarni talaffuz qiling — mikrofon baholaydi</p>
    </div>
</div>

<div class="container pb-5" style="max-width:680px;padding-top:1.75rem">

    <div class="d-flex align-items-center mb-3">
        <a href="<?= Url::to(['/mashq']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.84rem">
            <i class="fas fa-arrow-left mr-1"></i> Mashqlar
        </a>
        <div class="ml-auto" style="font-size:.8rem;color:var(--light-text)">
            <i class="fas fa-info-circle mr-1"></i>Chrome/Edge kerak
        </div>
    </div>

    <!-- Browser warning -->
    <div class="no-speech-alert" id="noSpeechWarn">
        <i class="fas fa-exclamation-triangle mr-1"></i>
        Brauzeringiz ovoz tanishni qo'llab-quvvatlamaydi. Iltimos, <strong>Chrome</strong> yoki <strong>Edge</strong> dan foydalaning.
    </div>

    <!-- Main Card -->
    <div class="speak-main-card mb-3">

        <!-- Letter display area -->
        <div class="speak-display-area">
            <!-- Mode selector -->
            <div class="d-flex justify-content-center mb-3" style="gap:.5rem">
                <button onclick="setMode('letter')" id="modeLetter" class="btn-muallim" style="font-size:.8rem;padding:.4rem 1rem">Harflar</button>
                <button onclick="setMode('name')"   id="modeName"   class="btn-muallim-outline" style="font-size:.8rem;padding:.4rem 1rem">Ismlar</button>
            </div>

            <div class="speak-letter-big" id="displayAr">—</div>
            <div class="speak-letter-name" id="displayName"></div>
            <div class="speak-letter-trans" id="displayTrans"></div>
        </div>

        <!-- Controls -->
        <div class="speak-controls">

            <!-- Session progress -->
            <div class="session-bar-wrap">
                <div class="d-flex justify-content-between" style="font-size:.8rem;color:var(--mid-text)">
                    <span>Sessiya</span>
                    <span id="sessionStats">0 / 0 &nbsp;<strong id="sessionPct" style="color:var(--gold)">—</strong></span>
                </div>
                <div class="session-bar-track">
                    <div class="session-bar-fill" id="sessionBar" style="width:0%;background:var(--gold)"></div>
                </div>
            </div>

            <!-- Waveform + Mic + Score row -->
            <div class="d-flex align-items-center justify-content-center" style="gap:2rem">
                <!-- Waveform -->
                <div class="waveform-row" id="waveform">
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                    <div class="wave-bar"></div>
                </div>

                <!-- Mic button with rings -->
                <div class="mic-center" id="micWrap">
                    <div class="mic-ring-1"></div>
                    <div class="mic-ring-2"></div>
                    <div class="mic-ring-3"></div>
                    <button class="mic-btn-main" id="micBtn" onclick="toggleRec()">
                        <i class="fas fa-microphone" id="micIcon"></i>
                    </button>
                </div>

                <!-- Score circle -->
                <div class="score-wrap" id="scoreWrap" style="opacity:.35">
                    <div class="score-circle-big" id="scoreCircle">—</div>
                    <div class="score-label" id="scoreLabel">Natija</div>
                </div>
            </div>

            <!-- Status text -->
            <div class="speak-status-txt" id="statusText">Bosing va harfni talaffuz qiling</div>

            <!-- Heard text -->
            <div class="heard-display" id="heardText">—</div>

            <!-- Action buttons -->
            <div class="speak-actions">
                <button class="btn-muallim-outline" onclick="playTTS()" style="font-size:.84rem;padding:.5rem 1.1rem;border-radius:10px">
                    <i class="fas fa-volume-up mr-1"></i> Eshitish
                </button>
                <button class="btn-muallim-outline" onclick="nextLetter()" style="font-size:.84rem;padding:.5rem 1.1rem;border-radius:10px">
                    <i class="fas fa-forward mr-1"></i> Keyingi
                </button>
                <button class="btn-muallim-outline" onclick="resetSession()" style="font-size:.84rem;padding:.5rem 1.1rem;border-radius:10px;color:var(--mid-text)">
                    <i class="fas fa-redo mr-1"></i> Qayta
                </button>
            </div>
        </div>
    </div>

    <!-- History -->
    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:20px;padding:1.4rem">
        <div style="font-weight:700;font-size:.85rem;color:var(--mid-text);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.85rem">
            <i class="fas fa-history mr-1" style="color:var(--gold)"></i> So'nggi natijalar
        </div>
        <div class="speak-history" id="speakHistory">
            <div style="text-align:center;color:var(--light-text);font-size:.84rem;padding:.75rem">
                <i class="fas fa-microphone-slash" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.3"></i>
                Hali natija yo'q
            </div>
        </div>
    </div>
</div>

<script>
const LETTERS = <?= json_encode($letData, JSON_UNESCAPED_UNICODE) ?>;
let currentLetter = null, speakMode = 'letter';
let sessionOk = 0, sessionTotal = 0;
let recognition = null, isRecording = false;
let historyItems = [];

const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
if (!SpeechRecognition) {
    document.getElementById('noSpeechWarn').style.display = '';
    document.getElementById('micBtn').disabled = true;
}

function setMode(m) {
    speakMode = m;
    document.getElementById('modeLetter').className = m === 'letter' ? 'btn-muallim' : 'btn-muallim-outline';
    document.getElementById('modeLetter').style.cssText = 'font-size:.8rem;padding:.4rem 1rem';
    document.getElementById('modeName').className = m === 'name' ? 'btn-muallim' : 'btn-muallim-outline';
    document.getElementById('modeName').style.cssText = 'font-size:.8rem;padding:.4rem 1rem';
    nextLetter();
}

function nextLetter() {
    stopRec();
    currentLetter = LETTERS[Math.floor(Math.random() * LETTERS.length)];
    document.getElementById('displayAr').textContent = currentLetter.ar;
    if (speakMode === 'letter') {
        document.getElementById('displayName').textContent = currentLetter.name;
        document.getElementById('displayTrans').textContent = '/' + currentLetter.trans + '/';
    } else {
        document.getElementById('displayName').textContent = '';
        document.getElementById('displayTrans').textContent = '(ismini o\'qing: ' + currentLetter.name + ')';
    }
    document.getElementById('heardText').textContent = '—';
    resetScore();
    setStatus('Bosing va ' + (speakMode === 'letter' ? 'harfni' : 'harf ismini') + ' talaffuz qiling', 'var(--mid-text)');
}

function resetScore() {
    const sc = document.getElementById('scoreCircle');
    sc.textContent = '—';
    sc.style.borderColor = 'var(--border)';
    sc.style.color = 'var(--mid-text)';
    document.getElementById('scoreLabel').textContent = 'Natija';
    document.getElementById('scoreWrap').style.opacity = '.35';
}

function playTTS() {
    if (!currentLetter) return;
    if ('speechSynthesis' in window) {
        window.speechSynthesis.cancel();
        const u = new SpeechSynthesisUtterance(speakMode === 'letter' ? currentLetter.ar : currentLetter.name);
        u.lang = speakMode === 'letter' ? 'ar-SA' : 'ar-SA';
        u.rate = 0.7;
        window.speechSynthesis.speak(u);
    }
}

function toggleRec() {
    if (isRecording) stopRec();
    else startRec();
}

function startRec() {
    if (!SpeechRecognition || !currentLetter) return;
    isRecording = true;
    document.getElementById('micWrap').classList.add('mic-active');
    document.getElementById('waveform').classList.add('mic-active');
    document.getElementById('micIcon').className = 'fas fa-stop';
    document.getElementById('heardText').textContent = '...';
    resetScore();
    setStatus('🔴 Tinglanyapti...', '#dc3545');

    recognition = new SpeechRecognition();
    recognition.lang = 'ar-SA';
    recognition.interimResults = false;
    recognition.maxAlternatives = 6;
    recognition.onresult = (e) => processResult(Array.from(e.results[0]).map(r => r.transcript.trim()));
    recognition.onerror = (e) => {
        stopRec();
        const msgs = {
            'no-speech':    'Ovoz eshitilmadi. Mikrofonga yaqinroq gapiring.',
            'not-allowed':  'Mikrofon ruxsati berilmagan.',
            'audio-capture':'Mikrofon topilmadi.',
        };
        setStatus(msgs[e.error] || 'Xatolik: ' + e.error, '#dc3545');
        document.getElementById('heardText').textContent = '—';
    };
    recognition.onend = () => {
        isRecording = false;
        document.getElementById('micWrap').classList.remove('mic-active');
        document.getElementById('waveform').classList.remove('mic-active');
        document.getElementById('micIcon').className = 'fas fa-microphone';
        if (document.getElementById('statusText').textContent.startsWith('🔴')) {
            setStatus('Qayta urinib ko\'ring', 'var(--mid-text)');
        }
    };
    recognition.start();
}

function stopRec() {
    if (recognition) { try { recognition.stop(); } catch(e){} recognition = null; }
    isRecording = false;
    document.getElementById('micWrap').classList.remove('mic-active');
    document.getElementById('waveform').classList.remove('mic-active');
    document.getElementById('micIcon').className = 'fas fa-microphone';
}

function processResult(candidates) {
    stopRec();
    document.getElementById('heardText').textContent = candidates[0] || '?';

    const targetAr = currentLetter.ar;
    const targetName = currentLetter.name.toLowerCase();
    let best = 0;

    candidates.forEach(c => {
        const cc = c.trim();
        if (cc === targetAr) { best = Math.max(best, 100); return; }
        if (cc.includes(targetAr) || targetAr.includes(cc)) best = Math.max(best, 85);
        if (speakMode === 'name') {
            const cn = cc.toLowerCase();
            if (cn === targetName) { best = Math.max(best, 100); return; }
            best = Math.max(best, Math.round(similarity(cn, targetName) * 100));
        }
        best = Math.max(best, Math.round(similarity(cc, targetAr) * 100));
    });

    showScore(best);
    sessionTotal++;
    if (best >= 60) sessionOk++;
    updateSession();
    addHistory(currentLetter, best, candidates[0]);
    setTimeout(nextLetter, 2400);
}

function showScore(pct) {
    const sc = document.getElementById('scoreCircle');
    let color = '#dc3545', lbl = 'Qayta urining';
    if (pct >= 90)      { color = '#28a745'; lbl = 'Mukammal! 🌟'; }
    else if (pct >= 75) { color = '#20c997'; lbl = 'Ajoyib!'; }
    else if (pct >= 60) { color = '#fd7e14'; lbl = 'Yaxshi!'; }
    else if (pct >= 40) { color = '#ffc107'; lbl = 'Mashq kerak'; }

    sc.textContent = pct + '%';
    sc.style.borderColor = color;
    sc.style.color = color;
    sc.style.boxShadow = '0 0 18px ' + color + '44';
    document.getElementById('scoreLabel').textContent = lbl;
    document.getElementById('scoreWrap').style.opacity = '1';
    setStatus(lbl, color);
}

function updateSession() {
    const pct = sessionTotal > 0 ? Math.round(sessionOk / sessionTotal * 100) : 0;
    document.getElementById('sessionStats').innerHTML = sessionOk + ' / ' + sessionTotal + ' &nbsp;<strong id="sessionPct" style="color:var(--gold)">' + (sessionTotal > 0 ? pct + '%' : '—') + '</strong>';
    const bar = document.getElementById('sessionBar');
    bar.style.width = pct + '%';
    bar.style.background = pct >= 70 ? '#28a745' : pct >= 40 ? 'var(--gold)' : '#dc3545';
}

function resetSession() {
    sessionOk = sessionTotal = 0;
    historyItems = [];
    updateSession();
    document.getElementById('speakHistory').innerHTML = '<div style="text-align:center;color:var(--light-text);font-size:.84rem;padding:.75rem"><i class="fas fa-microphone-slash" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.3"></i>Hali natija yo\'q</div>';
    nextLetter();
}

function addHistory(letter, score, heard) {
    historyItems.unshift({letter, score, heard});
    if (historyItems.length > 20) historyItems.pop();
    const container = document.getElementById('speakHistory');
    container.innerHTML = '';
    historyItems.forEach(item => {
        const color = item.score >= 75 ? '#28a745' : item.score >= 60 ? '#fd7e14' : '#dc3545';
        const d = document.createElement('div');
        d.className = 'hist-row';
        d.innerHTML = `
            <span class="hist-ar">${item.letter.ar}</span>
            <span class="hist-name">${item.letter.name}</span>
            <span class="hist-heard">"${item.heard || '?'}"</span>
            <span class="hist-pct" style="color:${color}">${item.score}%</span>
        `;
        container.appendChild(d);
    });
}

function setStatus(text, color) {
    const el = document.getElementById('statusText');
    el.textContent = text;
    el.style.color = color;
}

function similarity(a, b) {
    if (!a || !b) return 0;
    if (a === b) return 1;
    const longer = a.length > b.length ? a : b;
    const shorter = a.length > b.length ? b : a;
    if (longer.length === 0) return 1;
    return (longer.length - editDistance(longer, shorter)) / longer.length;
}
function editDistance(a, b) {
    const m = a.length, n = b.length;
    const dp = Array.from({length: m+1}, (_, i) => Array.from({length: n+1}, (_, j) => i===0?j:j===0?i:0));
    for (let i=1;i<=m;i++) for (let j=1;j<=n;j++) {
        dp[i][j] = a[i-1]===b[j-1] ? dp[i-1][j-1] : 1+Math.min(dp[i-1][j],dp[i][j-1],dp[i-1][j-1]);
    }
    return dp[m][n];
}

nextLetter();
</script>
