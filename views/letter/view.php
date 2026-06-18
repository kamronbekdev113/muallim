<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\ArabicLetter;
$this->title = $letter->name_uz . ' — ' . $letter->letter;
$examples    = $letter->getExamples();
$confusables = $letter->getConfusables();
$bookImg     = $letter->getBookPageImage();
$badges      = $letter->ruleBadges();
$mk          = $letter->makhrajInfo();
?>
<div class="container" style="max-width:780px;padding-top:2rem;padding-bottom:3rem">
    <!-- Back -->
    <a href="<?= Url::to(['/alifbo']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:0.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Alifboga qaytish
    </a>

    <!-- Hero -->
    <div class="letter-hero mt-3">
        <div style="font-size:.8rem;color:rgba(255,255,255,.65);letter-spacing:.1em">MUALLIMI SONIY — <?= (int)$letter->sort_order ?>-HARF</div>
        <div class="letter-display"><?= $letter->letter ?></div>
        <div class="letter-transliteration">[ <?= Html::encode($letter->transliteration) ?> ]</div>
        <div style="color:rgba(255,255,255,0.8);font-size:1.1rem;margin-top:0.5rem;font-weight:500"><?= Html::encode($letter->name_uz) ?></div>
        <?php if ($letter->intro): ?>
        <div style="display:flex;direction:rtl;justify-content:center;gap:1.4rem;margin-top:.7rem">
            <?php foreach (array_filter(explode(' ', $letter->intro), 'strlen') as $syl): ?>
            <div style="text-align:center">
                <div style="font-family:var(--arabic-font);font-size:2.8rem;color:#fff;line-height:1.2"><?= $syl ?></div>
                <div class="latin-read read-hidden" title="Ko'rsatish/yashirish" style="color:#ffe9b0;font-size:1.05rem;font-weight:700;cursor:pointer;direction:ltr"><?= Html::encode(ArabicLetter::reading($syl)) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="font-size:.75rem;color:rgba(255,255,255,.7);margin-top:.3rem">fatha (a) · kasra (i) · damma (u)</div>
        <?php endif; ?>
        <div class="mt-3" style="display:flex;gap:.6rem;justify-content:center;flex-wrap:wrap">
            <button class="aud-btn"
                    data-audio="<?= $letter->soundUrl() ? Url::to($letter->soundUrl()) : '' ?>"
                    data-text="<?= htmlspecialchars($letter->intro ?: $letter->letter) ?>"
                    style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:#fff;border-radius:24px;padding:.5rem 1.1rem;cursor:pointer;font-weight:600">
                <i class="fas fa-volume-up mr-1"></i> Eshitish (<?= Html::encode(ArabicLetter::reading($letter->intro ?: $letter->letter)) ?>)
            </button>
            <button class="speak-btn-main"
                    data-target="<?= htmlspecialchars($letter->intro ?: $letter->letter) ?>"
                    data-read="<?= htmlspecialchars(ArabicLetter::reading($letter->intro ?: $letter->letter)) ?>"
                    style="background:var(--gold);border:1px solid var(--gold);color:var(--green-deep);font-weight:700;border-radius:24px;padding:.5rem 1.1rem;cursor:pointer">
                <i class="fas fa-microphone mr-1"></i> O'qib ko'ring
            </button>
        </div>
        <div id="mainSpeakResult" style="color:#fff;font-size:.9rem;margin-top:.5rem;min-height:1.2em"></div>
    </div>

    <!-- Alijon qori video darsi (avval ESHITING) -->
    <?php if (!empty($letter->video_id)): ?>
    <div class="muallim-card" style="border-color:rgba(34,139,87,.4)">
        <div class="card-ornament">▶</div>
        <h6 style="font-weight:700;color:var(--green-deep);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:.3rem">🎧 AVVAL ESHITING — SHAYX ALIJON QORI</h6>
        <p style="font-size:.8rem;color:var(--mid-text);margin-bottom:.85rem">Ustoz bu harfni va so'zlarini Muallimi Soniy bo'yicha o'qib beradi. Avval diqqat bilan eshiting, keyin quyidagi so'zlarni takrorlang.</p>
        <div style="position:relative;width:100%;padding-bottom:56.25%;border-radius:12px;overflow:hidden;background:#000">
            <iframe src="https://www.youtube-nocookie.com/embed/<?= Html::encode($letter->video_id) ?>"
                    title="Alijon qori — <?= Html::encode($letter->name_uz) ?>"
                    style="position:absolute;inset:0;width:100%;height:100%;border:0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen loading="lazy"></iframe>
        </div>
    </div>
    <?php endif; ?>

    <!-- 4 Forms -->
    <div class="muallim-card mt-3">
        <div class="card-ornament">م</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:1rem">HARF SHAKLLARI</h6>
        <div class="letter-forms-grid" style="direction:rtl">
            <?php
            $forms = [
                ['Yakka', $letter->isolated, 'So\'z tashqarida'],
                ['Boshida', $letter->initial, 'So\'z boshida'],
                ["O'rtada", $letter->medial, "So'z o'rtasida"],
                ['Oxirida', $letter->final, 'So\'z oxirida'],
            ];
            foreach ($forms as $f): ?>
            <div class="letter-form-item">
                <div class="form-label-small"><?= $f[0] ?></div>
                <div class="form-arabic-text"><?= $f[1] ?></div>
                <div style="font-size:0.65rem;color:var(--light-text);margin-top:2px"><?= $f[2] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pronunciation / makhraj -->
    <?php if ($letter->pronunciation_note): ?>
    <div class="muallim-card mt-3">
        <div class="card-ornament">📢</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:0.75rem">TALAFFUZ (MAXRAJ)</h6>
        <p style="color:var(--dark-text);margin:0"><?= Html::encode($letter->pronunciation_note) ?></p>
    </div>
    <?php endif; ?>

    <!-- Maxraj (chiqish o'rni) + diagramma -->
    <div class="muallim-card mt-3">
        <div class="card-ornament">👄</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:.3rem">MAXRAJ — QAYERDAN CHIQADI</h6>
        <p style="color:var(--green-deep);font-weight:700;margin:0 0 .2rem"><?= Html::encode($mk['title']) ?></p>
        <p style="color:var(--dark-text);font-size:.9rem;margin-bottom:.85rem"><?= Html::encode($mk['desc']) ?></p>

        <!-- Harflar maxraji jadvali — «<?= $letter->letter ?>» qayerdaligini toping -->
        <img src="<?= Url::to('@web/img/makhraj/Makhiarj-letters-123.png') ?>" alt="Harflar maxraji jadvali"
             style="width:100%;border-radius:12px;border:1px solid var(--border);background:#fff;cursor:zoom-in"
             onclick="window.open(this.src,'_blank')">
        <p style="text-align:center;font-size:.8rem;color:var(--light-text);margin:.4rem 0 0">Rasmda «<?= Html::encode($letter->letter) ?>» harfining og'izdagi o'rnini toping (<?= Html::encode($mk['title']) ?>)</p>

        <details style="margin-top:.85rem">
            <summary style="cursor:pointer;font-size:.82rem;color:var(--green-deep);font-weight:600">🫁 Og'iz-bo'g'iz kesimi (5 asosiy soha)</summary>
            <img src="<?= Url::to('@web/img/makhraj/ARTICULATION-POINTS-2.jpg') ?>" alt="Maxraj sohalari"
                 style="width:100%;border-radius:10px;border:1px solid var(--border);background:#fff;margin-top:.5rem;cursor:zoom-in"
                 onclick="window.open(this.src,'_blank')">
        </details>
    </div>

    <!-- Tajvid qoida belgilari -->
    <?php if ($badges): ?>
    <div class="muallim-card mt-3">
        <div class="card-ornament">۝</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:.75rem">BU HARF QO'IDALARI</h6>
        <div style="display:flex;flex-direction:column;gap:.6rem">
            <?php foreach ($badges as $b): ?>
            <div style="display:flex;gap:.6rem;align-items:flex-start">
                <span style="flex-shrink:0;background:<?= $b[3] ?>;color:#fff;padding:3px 11px;border-radius:20px;font-size:.75rem;font-weight:700;white-space:nowrap"><?= Html::encode($b[1]) ?></span>
                <span style="font-size:.84rem;color:var(--dark-text)"><?= Html::encode($b[2]) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Mashq so'zlari (kitobdagi so'zlar) -->
    <?php if ($examples): ?>
    <div class="muallim-card mt-3">
        <div class="card-ornament">م</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:.3rem">MASHQ SO'ZLARI</h6>
        <p style="font-size:.78rem;color:var(--light-text);margin-bottom:.6rem">🔊 eshiting · 🎤 o'qib ko'ring (AI tekshiradi) · o'qilishini yashirib o'zingizni sinang.</p>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:.9rem">
            <button type="button" id="toggleLatinBtn" class="btn-muallim-outline" style="font-size:.78rem;padding:.35rem .85rem"><i class="fas fa-eye mr-1"></i> Lotin o'qilishini ko'rsatish</button>
        </div>
        <div class="ms-words-grid" id="wordsGrid">
            <?php foreach ($examples as $ex): $rd = ArabicLetter::reading($ex['ar']); ?>
            <div class="ms-word" data-ar="<?= htmlspecialchars($ex['ar']) ?>" data-read="<?= htmlspecialchars($rd) ?>">
                <div class="ms-word-ar"><?= $ex['ar'] ?></div>
                <div class="ms-word-read read-hidden" title="Ko'rsatish/yashirish"><?= Html::encode($rd) ?></div>
                <?php if (!empty($ex['uz']) && mb_strtolower(trim($ex['uz'])) !== mb_strtolower(trim($rd))): ?><div class="ms-word-uz"><?= Html::encode($ex['uz']) ?></div><?php endif; ?>
                <div class="ms-word-actions">
                    <button type="button" class="mini-btn aud-btn" data-audio="<?= ($wa = ArabicLetter::wordAudio($ex['ar'])) ? Url::to($wa) : '' ?>" data-text="<?= htmlspecialchars($ex['ar']) ?>" title="Eshitish"><i class="fas fa-volume-up"></i></button>
                    <button type="button" class="mini-btn speak-btn" title="O'qib ko'rish (AI tekshiradi)"><i class="fas fa-microphone"></i></button>
                </div>
                <div class="ms-word-result"></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Adashtiruvchi harflar -->
    <?php if ($confusables && !empty($confusables['juftlar'])): ?>
    <div class="muallim-card mt-3" style="border-color:rgba(201,168,76,.5)">
        <div class="card-ornament">⚠️</div>
        <h6 style="font-weight:700;color:#b9881f;text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:.3rem">ADASHTIRUVCHI HARFLAR</h6>
        <?php if (!empty($confusables['kalit'])): ?>
        <p style="font-size:.85rem;color:var(--mid-text);margin-bottom:.85rem"><?= Html::encode($confusables['kalit']) ?></p>
        <?php endif; ?>
        <div class="ms-words-grid">
            <?php foreach ($confusables['juftlar'] as $pair): ?>
            <div class="ms-word aud-btn" data-audio="<?= ($wp = ArabicLetter::wordAudio($pair)) ? Url::to($wp) : '' ?>" data-text="<?= htmlspecialchars($pair) ?>" style="cursor:pointer">
                <div class="ms-word-ar" style="font-size:1.7rem"><?= $pair ?></div>
                <div class="ms-word-read"><?= Html::encode(ArabicLetter::reading($pair)) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Asl kitob sahifasi -->
    <?php if ($bookImg): ?>
    <div class="muallim-card mt-3">
        <div class="card-ornament">📖</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:.3rem">ASL KITOB SAHIFASI</h6>
        <p style="font-size:.78rem;color:var(--light-text);margin-bottom:.85rem">Muallimi Soniy, <?= (int)$letter->book_page ?>-bet. So'zlarni asl manbada tekshirish uchun oching.</p>
        <a href="#" onclick="document.getElementById('bookPageModal').style.display='flex';return false;" class="btn-muallim-outline">
            <i class="fas fa-book-open mr-1"></i> <?= (int)$letter->book_page ?>-betni ochish
        </a>
    </div>
    <div id="bookPageModal" onclick="this.style.display='none'"
         style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;align-items:flex-start;justify-content:center;overflow:auto;padding:1rem">
        <div style="max-width:680px;width:100%;text-align:center" onclick="event.stopPropagation()">
            <div style="color:#fff;margin-bottom:.5rem;font-size:.85rem">Muallimi Soniy — <?= (int)$letter->book_page ?>-bet
                <button onclick="document.getElementById('bookPageModal').style.display='none'" style="float:right;background:none;border:1px solid rgba(255,255,255,.4);color:#fff;border-radius:6px;padding:2px 10px;cursor:pointer">✕ Yopish</button>
            </div>
            <img src="<?= Url::to($bookImg) ?>" alt="Muallimi Soniy <?= (int)$letter->book_page ?>-bet" style="width:100%;border-radius:8px;background:#fff">
        </div>
    </div>
    <?php endif; ?>

    <!-- Tezkor test -->
    <?php if (count($examples) >= 4): ?>
    <div class="muallim-card mt-3">
        <div class="card-ornament">📝</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:.3rem">TEZKOR TEST</h6>
        <p style="font-size:.8rem;color:var(--light-text);margin-bottom:.85rem">So'zni ko'ring — to'g'ri o'qilishini tanlang. O'zingizni sinab ko'ring!</p>
        <div id="quizBox"></div>
        <button type="button" id="startQuizBtn" class="btn-muallim"><i class="fas fa-play mr-1"></i> Testni boshlash</button>
    </div>
    <?php endif; ?>

    <!-- Nav -->
    <div class="lesson-nav">
        <?php if ($prev): ?>
        <a href="<?= Url::to(['/alifbo/' . $prev->id]) ?>" class="btn-muallim-outline">
            <i class="fas fa-arrow-left mr-1"></i> <?= $prev->letter ?> (<?= Html::encode($prev->name_uz) ?>)
        </a>
        <?php else: ?><span></span><?php endif; ?>
        <?php if ($next): ?>
        <a href="<?= Url::to(['/alifbo/' . $next->id]) ?>" class="btn-muallim">
            <?= $next->letter ?> (<?= Html::encode($next->name_uz) ?>) <i class="fas fa-arrow-right ml-1"></i>
        </a>
        <?php endif; ?>
    </div>
</div>

<style>
/* So'zlar — o'ngdan chapga tartibda (arab tili) */
.ms-words-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(112px,1fr));gap:.6rem;direction:rtl}
.ms-word{background:var(--parchment);border:1px solid var(--border);border-radius:12px;padding:.7rem .45rem;text-align:center;transition:.15s;direction:ltr}
.ms-word:hover{border-color:var(--gold);background:rgba(201,168,76,.08)}
.ms-word-ar{font-family:var(--arabic-font);font-size:2.4rem;line-height:1.45;color:var(--green-deep);direction:rtl}
[data-theme="dark"] .ms-word-ar{color:var(--gold)}
.ms-word-read{font-size:.92rem;font-weight:700;color:#b9881f;margin-top:4px;direction:ltr;min-height:1.1em;cursor:pointer}
.ms-word-uz{font-size:.76rem;color:var(--mid-text);margin-top:1px}
.ms-word-actions{display:flex;gap:.4rem;justify-content:center;margin-top:.55rem}
.mini-btn{width:34px;height:34px;border-radius:50%;border:1px solid var(--border);background:var(--card-bg);color:var(--green-deep);cursor:pointer;font-size:.85rem;display:inline-flex;align-items:center;justify-content:center;transition:.15s}
[data-theme="dark"] .mini-btn{color:var(--gold)}
.mini-btn:hover{border-color:var(--gold);background:rgba(201,168,76,.12)}
.mini-btn.rec{background:#e53935;color:#fff;border-color:#e53935;animation:pulseRec 1s infinite}
.mini-btn.playing{background:var(--gold);color:#fff;border-color:var(--gold)}
@keyframes pulseRec{0%,100%{box-shadow:0 0 0 0 rgba(229,57,53,.5)}50%{box-shadow:0 0 0 6px rgba(229,57,53,0)}}
.ms-word-result{font-size:.74rem;margin-top:.4rem;font-weight:600;min-height:0}
/* Lotin yashirish — har biri alohida bosib yashiriladi */
.ms-word-read.read-hidden,.latin-read.read-hidden{color:transparent!important;position:relative}
.ms-word-read.read-hidden::after{content:'• • •';color:#d8c79a;position:absolute;left:0;right:0;top:0;font-weight:700}
.latin-read.read-hidden::after{content:'• • •';color:rgba(255,255,255,.55);position:absolute;left:0;right:0;top:0;font-weight:700}
/* Test */
.quiz-opt{display:block;width:100%;text-align:center;padding:.7rem .9rem;margin-bottom:.5rem;border:1px solid var(--border);border-radius:10px;background:var(--card-bg);color:var(--dark-text);cursor:pointer;font-weight:700;font-size:1.05rem;transition:.15s}
.quiz-opt:hover{border-color:var(--gold)}
.quiz-opt.correct{background:#e8f5e9;border-color:#43a047;color:#2e7d32}
.quiz-opt.wrong{background:#ffebee;border-color:#e53935;color:#c62828}
</style>

<script>
(function(){
  var CSRF = <?= json_encode(Yii::$app->request->csrfToken) ?>;

  // === Audio: Google TTS (tizim ovozi shart emas) + zaxira speechSynthesis ===
  function speakFallback(text){
    if('speechSynthesis' in window){ try{ window.speechSynthesis.cancel();
      var u=new SpeechSynthesisUtterance(text); u.lang='ar-SA'; u.rate=.8; window.speechSynthesis.speak(u);
    }catch(e){} }
  }
  function playArabic(text, btn){
    if(!text) return;
    if(btn) btn.classList.add('playing');
    var done=function(){ if(btn) btn.classList.remove('playing'); };
    try{
      var url='<?= Url::to(['/mashq/tts']) ?>?q='+encodeURIComponent(text);
      var a=new Audio(url);
      a.onended=done; a.onerror=function(){ done(); speakFallback(text); };
      var p=a.play(); if(p&&p.catch){ p.catch(function(){ done(); speakFallback(text); }); }
      setTimeout(done, 6000);
    }catch(e){ done(); speakFallback(text); }
  }
  function playUrl(url, btn, fallbackText){
    if(btn) btn.classList.add('playing');
    var done=function(){ if(btn) btn.classList.remove('playing'); };
    try{
      var a=new Audio(url);
      a.onended=done;
      a.onerror=function(){ done(); if(fallbackText) playArabic(fallbackText, btn); };
      var p=a.play(); if(p&&p.catch){ p.catch(function(){ done(); if(fallbackText) playArabic(fallbackText, btn); }); }
      setTimeout(done, 6000);
    }catch(e){ done(); if(fallbackText) playArabic(fallbackText, btn); }
  }
  document.querySelectorAll('.aud-btn').forEach(function(b){
    b.addEventListener('click', function(e){ e.stopPropagation();
      if(b.dataset.audio){ playUrl(b.dataset.audio, b, b.dataset.text); }
      else { playArabic(b.dataset.text, b); }
    });
  });

  // === Lotin o'qilishini yashirish — global tugma + har biri alohida bosib ===
  var allReads = document.querySelectorAll('.ms-word-read,.latin-read');
  var tBtn = document.getElementById('toggleLatinBtn');
  var allHidden = true; // avto: yashirin holatda boshlanadi
  if (tBtn){
    tBtn.addEventListener('click', function(){
      allHidden = !allHidden;
      allReads.forEach(function(r){ r.classList.toggle('read-hidden', allHidden); });
      tBtn.innerHTML = allHidden ? '<i class="fas fa-eye mr-1"></i> Lotin o\'qilishini ko\'rsatish'
                                 : '<i class="fas fa-eye-slash mr-1"></i> Lotin o\'qilishini yashirish';
    });
  }
  // Har bir o'qilishni alohida bosib yashirish/ko'rsatish
  allReads.forEach(function(r){
    r.addEventListener('click', function(){ r.classList.toggle('read-hidden'); });
  });

  // === Nutq tekshiruvi (Web Speech API) ===
  var SR = window.SpeechRecognition || window.webkitSpeechRecognition;
  function checkSpeech(target, read, onResult){
    if(!window.isSecureContext){
      onResult({ok:false,msg:"🎤 Mikrofon faqat HTTPS yoki localhost'da ishlaydi. Saytni https orqali oching (yoki Chrome flag bilan http://muallim ni ishonchli qiling)."});
      return;
    }
    if(!SR){ onResult({ok:false,msg:"Brauzer mikrofonni qo'llab-quvvatlamaydi. Google Chrome ishlating."}); return; }
    var rec = new SR(); rec.lang='ar-SA'; rec.interimResults=false; rec.maxAlternatives=3;
    onResult({listening:true});
    rec.onresult=function(e){
      fetch('<?= Url::to(['/mashq/nutq-tekshir']) ?>',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-Token':CSRF},
        body:JSON.stringify({target:target,target_read:read,heard:e.results[0][0].transcript})})
        .then(function(r){return r.json();}).then(onResult)
        .catch(function(){onResult({ok:false,msg:'Server xatosi.'});});
    };
    rec.onerror=function(ev){ onResult({ok:false,msg: ev.error==='not-allowed' ? "Mikrofonga ruxsat berilmadi. Brauzer manzil yonidagi 🔒 dan mikrofonni yoqing." : "Ovoz eshitilmadi, qayta urinib ko'ring."}); };
    rec.start();
  }
  document.querySelectorAll('.speak-btn').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.stopPropagation();
      var tile=btn.closest('.ms-word'), res=tile.querySelector('.ms-word-result');
      checkSpeech(tile.dataset.ar, tile.dataset.read, function(r){
        if(r.listening){ btn.classList.add('rec'); res.style.color='#888'; res.textContent='🎤 Eshitilyapti...'; return; }
        btn.classList.remove('rec');
        res.style.color = r.ok ? '#2e7d32' : '#c62828';
        res.textContent = r.msg + (r.heard ? ' ('+r.heard+')' : '');
      });
    });
  });
  var mainBtn=document.querySelector('.speak-btn-main'), mainRes=document.getElementById('mainSpeakResult');
  // Xavfsiz kontekst bo'lmasa — oldindan eslatib qo'yamiz
  if(!window.isSecureContext && mainRes){
    mainRes.style.fontSize='.82rem';
    mainRes.innerHTML="ℹ️ Mikrofon faqat <b>https</b> yoki <b>localhost</b>da ishlaydi (brauzer qoidasi). «Eshitish» esa ishlaydi.";
  }
  if(mainBtn){ mainBtn.addEventListener('click', function(){
    checkSpeech(mainBtn.dataset.target, mainBtn.dataset.read, function(r){
      if(r.listening){ mainBtn.classList.add('rec'); mainRes.textContent='🎤 Eshitilyapti...'; return; }
      mainBtn.classList.remove('rec');
      mainRes.textContent = r.msg + (r.heard ? ' ('+r.heard+')' : '');
    });
  }); }

  // === Tezkor test ===
  var words = <?= json_encode(array_map(function($e){ return ['ar'=>$e['ar'],'read'=>\app\models\ArabicLetter::reading($e['ar'])]; }, array_values(array_filter($examples, function($e){ return mb_strlen(trim($e['ar']))>1; }))), JSON_UNESCAPED_UNICODE) ?>;
  var qBtn=document.getElementById('startQuizBtn'), qBox=document.getElementById('quizBox');
  if(qBtn && words.length>=4){
    var qi=0, score=0, order=[];
    function shuffle(a){for(var i=a.length-1;i>0;i--){var j=Math.floor(Math.random()*(i+1));var t=a[i];a[i]=a[j];a[j]=t;}return a;}
    function start(){ qi=0;score=0; order=shuffle(words.map(function(_,i){return i;})).slice(0,Math.min(8,words.length)); qBtn.style.display='none'; next(); }
    function next(){
      if(qi>=order.length){ qBox.innerHTML='<div style="text-align:center;padding:1rem"><div style="font-size:2rem">'+(score>order.length/2?'🎉':'💪')+'</div><div style="font-weight:700;font-size:1.1rem">Natija: '+score+' / '+order.length+'</div></div>'; qBtn.style.display=''; qBtn.innerHTML='<i class="fas fa-redo mr-1"></i> Qayta'; return; }
      var w=words[order[qi]];
      var opts=[w.read], pool=words.filter(function(x){return x.read!==w.read;}); shuffle(pool);
      for(var i=0;i<pool.length && opts.length<4;i++){ if(opts.indexOf(pool[i].read)<0) opts.push(pool[i].read); }
      shuffle(opts);
      var h='<div style="text-align:center;margin-bottom:.4rem;color:var(--light-text);font-size:.8rem">Savol '+(qi+1)+'/'+order.length+'</div>';
      h+='<div style="font-family:var(--arabic-font);font-size:3rem;color:var(--green-deep);text-align:center;direction:rtl;margin-bottom:.8rem">'+w.ar+'</div>';
      opts.forEach(function(o){ h+='<button type="button" class="quiz-opt" data-o="'+o.replace(/"/g,'&quot;')+'">'+o+'</button>'; });
      qBox.innerHTML=h;
      qBox.querySelectorAll('.quiz-opt').forEach(function(b){ b.addEventListener('click', function(){
        if(qBox.dataset.answered) return; qBox.dataset.answered='1';
        if(b.dataset.o===w.read){ b.classList.add('correct'); score++; }
        else { b.classList.add('wrong'); qBox.querySelectorAll('.quiz-opt').forEach(function(x){ if(x.dataset.o===w.read)x.classList.add('correct'); }); }
        setTimeout(function(){ qBox.dataset.answered=''; qi++; next(); }, 850);
      }); });
    }
    qBtn.addEventListener('click', start);
  }
})();
</script>

