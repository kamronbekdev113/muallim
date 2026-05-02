<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'AI Muallim — Savol-Javob';
$hasApi = !empty(Yii::$app->params['anthropicApiKey']);
?>
<style>
.ai-page-hero {
    background: linear-gradient(150deg, #0d2a1e 0%, #1b4332 50%, #0f3a28 100%);
    padding: 2.5rem 1rem 3.5rem;
    position: relative; overflow: hidden; text-align: center;
}
.ai-page-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Cg fill='none' stroke='%23C9A84C' stroke-width='0.5' opacity='0.12'%3E%3Cpolygon points='50,5 62,22 80,22 68,35 72,52 50,42 28,52 32,35 20,22 38,22'/%3E%3Ccircle cx='50' cy='50' r='30'/%3E%3Ccircle cx='50' cy='50' r='18'/%3E%3C/g%3E%3C/svg%3E");
    background-size: 100px;
}
/* Chat container */
.ai-chat-outer {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px var(--shadow);
    display: flex;
    flex-direction: column;
    height: 620px;
}
/* Chat header */
.ai-chat-top {
    background: linear-gradient(135deg, var(--green-deep), #2D6A4F);
    padding: 1rem 1.25rem;
    display: flex; align-items: center; gap: .85rem;
    flex-shrink: 0;
}
.ai-avatar-wrap { position: relative; }
.ai-avatar {
    width: 46px; height: 46px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold), #a07832);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--arabic-font); font-size: 1.5rem; color: var(--green-deep);
    font-weight: 900; flex-shrink: 0;
    box-shadow: 0 3px 12px rgba(0,0,0,.25);
}
.ai-status-dot {
    position: absolute; bottom: 2px; right: 2px;
    width: 11px; height: 11px; border-radius: 50%;
    background: #2ecc71; border: 2px solid var(--green-deep);
}
.ai-header-info { flex: 1; }
.ai-header-name { color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: .1rem; }
.ai-header-sub { color: rgba(255,255,255,.65); font-size: .78rem; }
.ai-header-badge {
    background: rgba(201,168,76,.2); border: 1px solid rgba(201,168,76,.35);
    color: var(--gold); padding: .2rem .7rem; border-radius: 20px;
    font-size: .72rem; font-weight: 600; letter-spacing: .04em;
}
/* Messages area */
.ai-msgs {
    flex: 1; overflow-y: auto; padding: 1.25rem;
    display: flex; flex-direction: column; gap: .9rem;
    scroll-behavior: smooth;
}
.ai-msgs::-webkit-scrollbar { width: 4px; }
.ai-msgs::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
/* Bubbles */
.msg-row { display: flex; flex-direction: column; }
.msg-row.user-row { align-items: flex-end; }
.msg-row.ai-row   { align-items: flex-start; }
.msg-bubble {
    max-width: 82%; padding: .8rem 1.05rem;
    border-radius: 18px; font-size: .87rem; line-height: 1.65;
    animation: msgIn .2s ease;
}
@keyframes msgIn { from{opacity:0;transform:translateY(6px);} to{opacity:1;transform:none;} }
.msg-user {
    background: linear-gradient(135deg, var(--green-deep), #2D6A4F);
    color: #fff; border-bottom-right-radius: 4px;
}
.msg-ai {
    background: var(--parchment-dark); color: var(--dark-text);
    border: 1px solid var(--border); border-bottom-left-radius: 4px;
}
[data-theme="dark"] .msg-ai { background: #1a2a3a; }
.msg-ai-arabic {
    font-family: var(--arabic-font); font-size: 1.25rem;
    color: var(--green-deep); direction: rtl; text-align: right;
    margin-bottom: .5rem; line-height: 2;
    padding-bottom: .5rem; border-bottom: 1px solid var(--border);
}
[data-theme="dark"] .msg-ai-arabic { color: var(--gold); }
.msg-time { font-size: .62rem; opacity: .45; margin-top: .3rem; }
/* Typing indicator */
.typing-bubble {
    background: var(--parchment-dark); border: 1px solid var(--border);
    border-radius: 18px; border-bottom-left-radius: 4px;
    padding: .75rem 1rem; display: inline-flex; gap: .3rem; align-items: center;
    animation: msgIn .2s ease;
}
[data-theme="dark"] .typing-bubble { background: #1a2a3a; }
.typing-bubble span {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--mid-text); animation: typDot 1.3s infinite;
}
.typing-bubble span:nth-child(2) { animation-delay: .2s; }
.typing-bubble span:nth-child(3) { animation-delay: .4s; }
@keyframes typDot { 0%,60%,100%{transform:translateY(0);opacity:.35;} 30%{transform:translateY(-6px);opacity:1;} }
/* Footer */
.ai-footer {
    padding: .85rem 1.15rem 1rem;
    border-top: 1px solid var(--border);
    background: var(--card-bg); flex-shrink: 0;
}
.ai-quick-wrap { display: flex; gap: .4rem; flex-wrap: wrap; margin-bottom: .65rem; }
.ai-quick-chip {
    background: rgba(201,168,76,.08); border: 1px solid rgba(201,168,76,.22);
    color: var(--mid-text); border-radius: 20px; padding: .22rem .7rem;
    font-size: .73rem; cursor: pointer; transition: .15s; white-space: nowrap;
}
.ai-quick-chip:hover { background: rgba(201,168,76,.18); border-color: var(--gold); color: var(--dark-text); }
.ai-input-row { display: flex; gap: .6rem; align-items: flex-end; }
.ai-textarea {
    flex: 1; border: 1.5px solid var(--border); border-radius: 14px;
    padding: .65rem 1rem; font-size: .88rem; color: var(--dark-text);
    background: var(--parchment); resize: none; outline: none;
    max-height: 90px; font-family: var(--ui-font); transition: border-color .2s;
    line-height: 1.5;
}
.ai-textarea:focus { border-color: var(--green-mid); box-shadow: 0 0 0 3px rgba(64,145,108,.12); }
[data-theme="dark"] .ai-textarea { background: #1a2a3a; color: var(--dark-text); }
.ai-send {
    width: 44px; height: 44px; border-radius: 12px; border: none; flex-shrink: 0;
    background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
    color: var(--gold); cursor: pointer; transition: .2s;
    display: flex; align-items: center; justify-content: center; font-size: 1.05rem;
}
.ai-send:hover:not(:disabled) { transform: scale(1.08); box-shadow: 0 4px 16px rgba(27,67,50,.4); }
.ai-send:disabled { opacity: .45; cursor: not-allowed; }
/* No API notice */
.no-api-notice {
    background: rgba(201,168,76,.08); border: 1px solid rgba(201,168,76,.25);
    border-radius: 12px; padding: .75rem 1.1rem; font-size: .83rem;
    color: var(--mid-text); margin-bottom: 1rem; text-align: center;
}
</style>

<!-- Hero -->
<div class="ai-page-hero">
    <div class="position-relative">
        <div style="font-family:var(--arabic-font);font-size:1.6rem;color:rgba(201,168,76,.7);margin-bottom:.3rem">الْمُعَلِّمُ الذَّكِيُّ</div>
        <h1 style="color:#fff;font-weight:800;font-size:1.7rem;margin-bottom:.35rem">🤖 AI Muallim</h1>
        <p style="color:rgba(255,255,255,.72);font-size:.9rem;margin:0">Arab tili va Qur'on haqida savol bering</p>
    </div>
</div>

<div class="container pb-5" style="max-width:700px;padding-top:1.75rem">

    <div class="d-flex align-items-center mb-3">
        <a href="<?= Url::to(['/mashq']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.84rem">
            <i class="fas fa-arrow-left mr-1"></i> Mashqlar
        </a>
        <?php if (!$hasApi): ?>
        <div class="ml-auto" style="font-size:.78rem;color:var(--mid-text)">
            <i class="fas fa-info-circle mr-1 text-warning"></i> Demo rejim
        </div>
        <?php endif; ?>
    </div>

    <?php if (!$hasApi): ?>
    <div class="no-api-notice">
        <i class="fas fa-robot mr-1"></i>
        <strong>Demo rejim:</strong> Oldindan tayyorlangan javoblar ko'rsatilmoqda.
        Haqiqiy AI uchun <code>anthropicApiKey</code> ni <code>config/params.php</code> ga qo'shing.
    </div>
    <?php endif; ?>

    <!-- Chat window -->
    <div class="ai-chat-outer mb-3" id="chatOuter">

        <!-- Header -->
        <div class="ai-chat-top">
            <div class="ai-avatar-wrap">
                <div class="ai-avatar">م</div>
                <div class="ai-status-dot"></div>
            </div>
            <div class="ai-header-info">
                <div class="ai-header-name">Muallim AI</div>
                <div class="ai-header-sub">Arab tili va Qur'on mutaxassisi</div>
            </div>
            <span class="ai-header-badge">
                <?= $hasApi ? '<i class="fas fa-bolt mr-1"></i>Claude AI' : '<i class="fas fa-book mr-1"></i>Demo' ?>
            </span>
        </div>

        <!-- Messages -->
        <div class="ai-msgs" id="aiMsgs">
            <!-- Welcome message -->
            <div class="msg-row ai-row">
                <div class="msg-bubble msg-ai">
                    <div class="msg-ai-arabic">السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ</div>
                    Assalomu alaykum! Men <strong>Muallim AI</strong> — arab tili va Qur'on bo'yicha yordamchingiz.<br><br>
                    Menga quyidagilar haqida savol bera olasiz:
                    <ul style="margin:.5rem 0 0 1rem;padding:0;font-size:.84rem">
                        <li>Arab harflari va ularning talaffuzi</li>
                        <li>Tajvid qoidalari</li>
                        <li>Qur'on suralar va oyatlar</li>
                        <li>Arab tili grammatikasi</li>
                        <li>Arabcha so'zlar ma'nosi</li>
                    </ul>
                </div>
                <div class="msg-time">Hozir</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="ai-footer">
            <!-- Quick prompts -->
            <div class="ai-quick-wrap" id="quickPrompts">
                <button class="ai-quick-chip" onclick="sendQuick(this)">الف nima?</button>
                <button class="ai-quick-chip" onclick="sendQuick(this)">Ghunna qoidasi</button>
                <button class="ai-quick-chip" onclick="sendQuick(this)">Fotiha surasi</button>
                <button class="ai-quick-chip" onclick="sendQuick(this)">Madd nima?</button>
                <button class="ai-quick-chip" onclick="sendQuick(this)">Bismillah ma'nosi</button>
                <button class="ai-quick-chip" onclick="sendQuick(this)">Qalqala harflari</button>
            </div>
            <!-- Input -->
            <div class="ai-input-row">
                <textarea class="ai-textarea" id="userInput" rows="1"
                    placeholder="Savolingizni yozing... (Enter — yuborish)"
                    onkeydown="handleKey(event)"
                    oninput="autoResize(this)"></textarea>
                <button class="ai-send" id="sendBtn" onclick="sendMsg()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Tips -->
    <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:1.25rem">
        <div style="font-weight:700;font-size:.85rem;color:var(--mid-text);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.85rem">
            <i class="fas fa-lightbulb mr-1" style="color:var(--gold)"></i> Maslahatlar
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem">
            <div style="background:var(--parchment-dark);border-radius:10px;padding:.65rem .85rem;font-size:.8rem;color:var(--mid-text)">
                <i class="fas fa-star" style="color:var(--gold);margin-right:.3rem"></i>Aniq savol bering
            </div>
            <div style="background:var(--parchment-dark);border-radius:10px;padding:.65rem .85rem;font-size:.8rem;color:var(--mid-text)">
                <i class="fas fa-language" style="color:var(--green-mid);margin-right:.3rem"></i>O'zbek yoki arab tilida
            </div>
            <div style="background:var(--parchment-dark);border-radius:10px;padding:.65rem .85rem;font-size:.8rem;color:var(--mid-text)">
                <i class="fas fa-book-open" style="color:var(--brown);margin-right:.3rem"></i>Qoida so'rasangiz misol ham
            </div>
            <div style="background:var(--parchment-dark);border-radius:10px;padding:.65rem .85rem;font-size:.8rem;color:var(--mid-text)">
                <i class="fas fa-redo" style="color:var(--mid-text);margin-right:.3rem"></i>Noaniq bo'lsa qayta so'rang
            </div>
        </div>
    </div>
</div>

<script>
const HAS_API = <?= $hasApi ? 'true' : 'false' ?>;
const API_URL = '<?= Url::to(['/mashq/ai-chat-api']) ?>';
let isBusy = false;

// Demo knowledge base (when no API key)
const DEMO_RESPONSES = [
    {
        keys: ['алеф','алиф','elif','الف','الأ','ألف','alef','alif'],
        ar: 'الأَلِف',
        text: '<strong>Alif (الف)</strong> — arab alifbosining birinchi harfi. U uzun "a" tovushini bildiradi va odatda old tomondan birikmaydigan harf hisoblanadi.\n\n<strong>4 ta shakli:</strong>\n• Isolated: ا\n• Initial: ا (o\'zgarishsiz)\n• Medial: ـا\n• Final: ـا\n\nAlif harfi faqat oldingi harf bilan birikadi, keyingi harf bilan birikmasligi uning o\'ziga xos xususiyatidir.'
    },
    {
        keys: ['ghunna','гхунна','ғунна','gunna'],
        ar: 'الغُنَّة',
        text: '<strong>Ghunna (الغنة)</strong> — burun ovozi bilan talaffuz qilinadigan tajvid qoidasi.\n\n<strong>Ghunna harflari:</strong> ن (nun) va م (mim)\n\nGhunna ikki holda bo\'ladi:\n1. <strong>Yangi ghunna:</strong> Tashdidli nun yoki mim (نّ / مّ) — 2 harakatlik burun ovozi\n2. <strong>Idgham va ikhfa:</strong> Ba\'zi qoidalarda ghunna bilan birga o\'qiladi\n\nAmaliyot: بِسْمِ — mim (م) harfini talaffuz qilganda burun rezonansiga e\'tibor bering.'
    },
    {
        keys: ['маdd','мад','мадд','madd','مد','ماد'],
        ar: 'الْمَدّ',
        text: '<strong>Madd (المد)</strong> — cho\'ziq tovush qoidasi. Arabchada ba\'zi harflar cho\'zilib talaffuz qilinadi.\n\n<strong>Madd harflari:</strong>\n• ا (alif) — fathadan keyin: ـَا\n• و (waw) — dammadan keyin: ـُو\n• ي (ya) — kasradan keyin: ـِي\n\n<strong>Madd turlari:</strong>\n• <strong>Madd Tabii (طبيعي):</strong> 2 harakat — oddiy cho\'ziq\n• <strong>Madd Muttasil:</strong> 4-5 harakat — hamza bir so\'zda bo\'lsa\n• <strong>Madd Munfasil:</strong> 4-5 harakat — hamza keyingi so\'zda\n• <strong>Madd Lazim:</strong> 6 harakat — sukun yoki tashdid bo\'lsa'
    },
    {
        keys: ['qalqala','калкала','قلقلة'],
        ar: 'القَلْقَلَة',
        text: '<strong>Qalqala (القلقلة)</strong> — titroq ovoz qoidasi. Sukun holatidagi 5 harf bilan qo\'llaniladi.\n\n<strong>Qalqala harflari (قطب جد):</strong>\n• ق — Qof\n• ط — To\n• ب — Bo\n• ج — Jim\n• د — Dal\n\n<strong>Misol:</strong> يَقْطَعُ — "yaqta\'u" so\'zida ق va ط harflari qalqala bilan o\'qiladi.\n\n<strong>Kuchli vs yengil:</strong> So\'z oxirida (waqf) qalqala kuchliroq bo\'ladi.'
    },
    {
        keys: ['fotiha','fatihа','фотиха','الفاتحة'],
        ar: 'سُورَةُ الْفَاتِحَة',
        text: '<strong>Fotiha surasi (الفاتحة)</strong> — Qur\'onning 1-surasi, 7 oyat.\n\nIsmlari: Al-Fatiha (Ochilish), Umm ul-Kitab (Kitob onasi), As-Sab\'ul Masani (Yetti takrorlangan)\n\n<strong>Fotiha namozda:</strong> Har bir rak\'atda o\'qish farzdir (Hanafiy mazhabida). Sunniy hamda shia muslimlar namozda o\'qiydi.\n\n<strong>Ma\'nosi:</strong> "Barcha maqtovlar Allohga..." deb boshlanadigan bu sura Allohga hamdu sano, Uning yo\'lida hidoyat so\'rash duosidir.'
    },
    {
        keys: ['bismillah','бисмиллах','بسم','bismilla'],
        ar: 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ',
        text: '<strong>Bismillah</strong> — "Allohning nomi bilan (boshlayman)" ma\'nosini beradi.\n\n<strong>To\'liq matn:</strong>\nبِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ\nBismillāhi r-raḥmāni r-raḥīm\n\n<strong>So\'zma-so\'z:</strong>\n• بِسْمِ — nomi bilan\n• اللَّهِ — Alloh\n• الرَّحْمَٰنِ — Rahmon (cheksiz rahmatli)\n• الرَّحِيمِ — Rahim (bepoyon mehribon)\n\nHar ishni Bismillah bilan boshlash sunnatdir.'
    },
    {
        keys: ['ikhfa','ихфа','إخفاء'],
        ar: 'الإِخْفَاء',
        text: '<strong>Ikhfa (الإخفاء)</strong> — yashirish qoidasi. Nun sakin (نْ) yoki tanvin keyingi 15 harf oldida ikhfa bilan o\'qiladi.\n\n<strong>Ikhfa harflari:</strong> ت ث ج د ذ ز س ش ص ض ط ظ ف ق ك\n\n<strong>Talaffuz:</strong> Nun tovushi to\'liq aytilmaydi, lekin yo\'qolib ham ketmaydi — burun orqali chiqariladigan ovoz bilan ikhfa harfiga o\'tiladi.\n\n<strong>Misol:</strong> مِنْ تَحْتِهَا — "min" dagi نْ "ta" oldida ikhfa bo\'ladi.'
    },
    {
        keys: ['idgham','идгом','إدغام'],
        ar: 'الإِدْغَام',
        text: '<strong>Idgham (الإدغام)</strong> — kiritish/eritish qoidasi. Nun sakin yoki tanvin keyingi 6 harf oldida qo\'llaniladi.\n\n<strong>Idgham harflari (يرملون):</strong> ي ر م ل و ن\n\n<strong>Ikki turi:</strong>\n• <strong>Idgham Bighunna:</strong> Ghunna bilan — ن م و ي harflari oldida\n• <strong>Idgham Bilaghunna:</strong> Ghunnasiz — ر ل harflari oldida\n\n<strong>Shart:</strong> Idgham faqat ikki alohida so\'z orasida bo\'ladi.'
    },
    {
        keys: ['harakat','harakalar','ҳаракат','harakatlar'],
        ar: 'الحَرَكَات',
        text: '<strong>Arab harakatlari (الحركات)</strong>:\n\n• <strong>فَتْحَة (Fatha)</strong> — harf ustida, "a" tovushi: بَ = ba\n• <strong>كَسْرَة (Kasra)</strong> — harf ostida, "i" tovushi: بِ = bi\n• <strong>ضَمَّة (Damma)</strong> — harf ustida (halqa), "u" tovushi: بُ = bu\n• <strong>سُكُون (Sukun)</strong> — harf ustida (doira), tovush yo\'q: بْ\n• <strong>شَدَّة (Tashdid)</strong> — harf ustida (w-shakl), ikki marta: بَّ = bba\n• <strong>Tanwin:</strong> Nounifikatsiya — ـً = an, ـٍ = in, ـٌ = un'
    },
];

function getDemoReply(text) {
    const q = text.toLowerCase();
    for (const r of DEMO_RESPONSES) {
        if (r.keys.some(k => q.includes(k.toLowerCase()))) {
            return { ar: r.ar, text: r.text.replace(/\n/g, '<br>') };
        }
    }
    return {
        ar: null,
        text: 'Kechirasiz, bu savolga demo rejimda javob berolmadim. <strong>Maslahat:</strong> "Ghunna", "Madd", "Qalqala", "Bismillah", "Fotiha" kabi kalit so\'zlardan foydalaning, yoki haqiqiy AI uchun API kalitini sozlang.'
    };
}

function sendQuick(btn) {
    document.getElementById('userInput').value = btn.textContent;
    sendMsg();
}

function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMsg(); }
}

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 90) + 'px';
}

async function sendMsg() {
    const input = document.getElementById('userInput');
    const text = input.value.trim();
    if (!text || isBusy) return;

    appendMsg(text, 'user');
    input.value = '';
    autoResize(input);
    isBusy = true;
    document.getElementById('sendBtn').disabled = true;

    const typingId = showTyping();

    try {
        let reply;
        if (HAS_API) {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-Token': getCsrf()},
                body: JSON.stringify({message: text})
            });
            const data = await res.json();
            if (data.error) throw new Error(data.error);
            reply = {ar: data.ar || null, text: data.text};
        } else {
            await sleep(900 + Math.random() * 600);
            reply = getDemoReply(text);
        }
        removeTyping(typingId);
        appendAiMsg(reply.ar, reply.text);
    } catch(err) {
        removeTyping(typingId);
        appendAiMsg(null, 'Xatolik yuz berdi: ' + err.message);
    }

    isBusy = false;
    document.getElementById('sendBtn').disabled = false;
    input.focus();
}

function appendMsg(text, who) {
    const msgs = document.getElementById('aiMsgs');
    const d = document.createElement('div');
    d.className = 'msg-row ' + (who === 'user' ? 'user-row' : 'ai-row');
    const now = new Date().toLocaleTimeString('uz', {hour:'2-digit',minute:'2-digit'});
    d.innerHTML = `<div class="msg-bubble msg-${who}">${escHtml(text)}</div><div class="msg-time">${now}</div>`;
    msgs.appendChild(d);
    msgs.scrollTop = msgs.scrollHeight;
}

function appendAiMsg(ar, text) {
    const msgs = document.getElementById('aiMsgs');
    const d = document.createElement('div');
    d.className = 'msg-row ai-row';
    const now = new Date().toLocaleTimeString('uz', {hour:'2-digit',minute:'2-digit'});
    const arHtml = ar ? `<div class="msg-ai-arabic">${ar}</div>` : '';
    d.innerHTML = `<div class="msg-bubble msg-ai">${arHtml}${text}</div><div class="msg-time">${now}</div>`;
    msgs.appendChild(d);
    msgs.scrollTop = msgs.scrollHeight;
}

function showTyping() {
    const msgs = document.getElementById('aiMsgs');
    const id = 'typing-' + Date.now();
    const d = document.createElement('div');
    d.className = 'msg-row ai-row';
    d.id = id;
    d.innerHTML = `<div class="typing-bubble"><span></span><span></span><span></span></div>`;
    msgs.appendChild(d);
    msgs.scrollTop = msgs.scrollHeight;
    return id;
}

function removeTyping(id) {
    const el = document.getElementById(id);
    if (el) el.remove();
}

function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}
function sleep(ms) { return new Promise(r => setTimeout(r, ms)); }
function getCsrf() {
    const m = document.cookie.match(/(?:^|; )_csrf[^=]*=([^;]*)/);
    return m ? decodeURIComponent(m[1]) : '';
}
</script>
