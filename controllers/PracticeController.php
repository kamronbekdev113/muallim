<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\ArabicLetter;
use app\models\Vocabulary;
use app\models\TajweedRule;

class PracticeController extends Controller
{
    // ----- Mavjud -----
    public function actionLetters()
    {
        $letters = ArabicLetter::getAllOrdered();
        return $this->render('letters', compact('letters'));
    }

    public function actionWords()
    {
        $words = Vocabulary::find()->orderBy('RAND()')->limit(30)->all();
        return $this->render('words', compact('words'));
    }

    // ----- Yangi mashqlar -----

    /**
     * Shakl mashqi: harfning to'rt shaklini o'rganish (quiz)
     */
    public function actionForms()
    {
        $letters = ArabicLetter::getAllOrdered();
        return $this->render('forms', compact('letters'));
    }

    /**
     * Talaffuz mashqi: harfni eshitib/ko'rib ismini topish
     */
    public function actionPronunciation()
    {
        $letters = ArabicLetter::getAllOrdered();
        return $this->render('pronunciation', compact('letters'));
    }

    /**
     * Bog'lanish mashqi: harflar qanday birikishini o'rganish
     */
    public function actionConnections()
    {
        $letters = ArabicLetter::getAllOrdered();

        // Ikki tomonlama birikuvchi harflar (alef, vav, dal, zel, ra, zayn bundan mustasno)
        $nonConnecting = ['ا','و','د','ذ','ر','ز'];

        return $this->render('connections', [
            'letters'        => $letters,
            'nonConnecting'  => $nonConnecting,
        ]);
    }

    /** Practice hub */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /** Harakat (vowel) practice */
    public function actionHarakat()
    {
        return $this->render('harakat');
    }

    /** Tajveed rules quiz */
    public function actionTajvidTest()
    {
        $rules = TajweedRule::getAllActive();
        return $this->render('tajvid-test', compact('rules'));
    }

    /** Quran vocabulary */
    public function actionLugat()
    {
        $words = Vocabulary::find()->orderBy('category ASC, difficulty ASC')->all();
        return $this->render('lugat', compact('words'));
    }

    /** Memory match game */
    public function actionMemory()
    {
        $letters = ArabicLetter::getAllOrdered();
        return $this->render('memory', compact('letters'));
    }

    /** Speed quiz — 60 seconds rapid fire */
    public function actionSpeedQuiz()
    {
        $letters = ArabicLetter::getAllOrdered();
        return $this->render('speed-quiz', compact('letters'));
    }

    /** Speaking practice — Web Speech API */
    public function actionSpeaking()
    {
        $letters = ArabicLetter::getAllOrdered();
        return $this->render('speaking', compact('letters'));
    }

    /** AI Chat practice page */
    public function actionAiChat()
    {
        return $this->render('ai-chat');
    }

    /** AI Chat API endpoint — POST JSON */
    public function actionAiChatApi()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->method !== 'POST') {
            return ['error' => 'POST only'];
        }

        $body    = Yii::$app->request->rawBody;
        $data    = json_decode($body, true);
        $message = trim($data['message'] ?? '');

        if ($message === '') {
            return ['error' => 'Empty message'];
        }

        $apiKey = Yii::$app->params['anthropicApiKey'] ?? '';
        if (empty($apiKey)) {
            return ['error' => 'No API key configured'];
        }

        $systemPrompt = <<<'SYS'
Siz "Muallim AI" — o'zbek tilida arab tili va Qur'on o'rgatuvchi mutaxassis yordamchi.
Quyidagi qoidalarga amal qiling:
1. Faqat arab tili, Qur'on, tajvid, islom tili va din haqidagi savollarga javob bering.
2. Javoblaringiz o'zbek tilida bo'lsin.
3. Arab so'zlari va oyatlarni arabcha yozing, keyin o'zbek tilida izohlang.
4. Tajvid qoidalarini tushuntirganda amaliy misollar keltiring.
5. Agar arab ibora yoki oyat mavjud bo'lsa, avval arabchada yozing (json da "ar" maydonida), keyin tushuntiring.
6. Javobni JSON formatida qaytaring: {"ar": "arabcha matn yoki null", "text": "o'zbek tilidagi tushuntirish"}
Faqat JSON formatida javob qaytaring, boshqa hech narsa yozmang.
SYS;

        $ch = curl_init('https://api.anthropic.com/v1/messages');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key: ' . $apiKey,
                'anthropic-version: 2023-06-01',
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'model'      => 'claude-haiku-4-5-20251001',
                'max_tokens' => 1024,
                'system'     => $systemPrompt,
                'messages'   => [
                    ['role' => 'user', 'content' => $message],
                ],
            ]),
            CURLOPT_TIMEOUT => 30,
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['error' => 'cURL: ' . $err];
        }

        $resp = json_decode($raw, true);
        if (isset($resp['error'])) {
            return ['error' => $resp['error']['message'] ?? 'Anthropic API error'];
        }

        $content = $resp['content'][0]['text'] ?? '';
        // Try to parse JSON from Claude's response
        $parsed = json_decode($content, true);
        if (is_array($parsed) && isset($parsed['text'])) {
            return ['ar' => $parsed['ar'] ?? null, 'text' => $parsed['text']];
        }
        // Fallback: return raw text
        return ['ar' => null, 'text' => nl2br(htmlspecialchars($content))];
    }

    /**
     * Ovoz proxy: Google TTS dan arabcha talaffuzni server orqali olib, MP3 qaytaradi.
     * Brauzer o'z domenidan eshitadi (CORS/referer muammosiz). GET ?q=...
     */
    public function actionTts($q = '')
    {
        $q = trim($q);
        if ($q === '' || mb_strlen($q) > 200) {
            throw new \yii\web\BadRequestHttpException('q kerak');
        }
        $resp = Yii::$app->response;

        // Diskka keshlash: har so'z Google'dan bir marta olinadi
        $dir = Yii::getAlias('@runtime') . '/tts';
        if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
        $cacheFile = $dir . '/' . md5($q) . '.mp3';

        if (is_file($cacheFile) && filesize($cacheFile) > 500) {
            $mp3 = file_get_contents($cacheFile);
        } else {
            $url = 'https://translate.googleapis.com/translate_tts?ie=UTF-8&client=gtx&tl=ar&q=' . rawurlencode($q);
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_USERAGENT      => 'Mozilla/5.0',
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);
            $mp3  = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $ct   = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close($ch);

            if ($mp3 === false || $code !== 200 || strpos((string)$ct, 'audio') === false) {
                $resp->statusCode = 502;
                $resp->content = 'tts failed';
                return $resp;
            }
            @file_put_contents($cacheFile, $mp3);
        }

        $resp->format = Response::FORMAT_RAW;
        $resp->headers->set('Content-Type', 'audio/mpeg');
        $resp->headers->set('Cache-Control', 'public, max-age=604800');
        $resp->content = $mp3;
        return $resp;
    }

    /**
     * Nutq tekshiruvi: foydalanuvchi o'qigan (heard) ni maqsad (target) bilan solishtiradi.
     * Mahalliy taqqoslash + (kalit bo'lsa) AI fikri. POST JSON: {target, target_read, heard}
     */
    public function actionCheckSpeech()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->method !== 'POST') {
            return ['ok' => false, 'msg' => 'POST only'];
        }
        $data       = json_decode(Yii::$app->request->rawBody, true) ?: [];
        $target     = trim($data['target'] ?? '');
        $targetRead = trim($data['target_read'] ?? '');
        $heard      = trim($data['heard'] ?? '');

        if ($target === '') return ['ok' => false, 'msg' => "Maqsad so'z yo'q."];
        if ($heard === '')  return ['ok' => false, 'msg' => "Ovoz eshitilmadi. Mikrofonga ruxsat bering va qaytadan urinib ko'ring."];

        // Arabchani soddalashtirish: harakat, tatweel, hamza/ta-marbuta variantlari
        $norm = function ($s) {
            $s = preg_replace('/[\x{064B}-\x{0652}\x{0670}\x{0640}]/u', '', $s);
            $s = str_replace(['أ', 'إ', 'آ', 'ٱ'], 'ا', $s);
            $s = str_replace(['ة'], 'ه', $s);
            $s = str_replace(['ى'], 'ي', $s);
            $s = preg_replace('/[\s\.\,\-–]+/u', '', $s);
            return $s;
        };
        $t = $norm($target);
        $h = $norm($heard);

        $score = 0;
        if ($t !== '' && $t === $h) {
            $score = 100;
        } else {
            $pct = 0;
            similar_text($t, $h, $pct);
            $score = (int)round($pct);
        }

        // Ixtiyoriy: AI fikri (kalit sozlangan bo'lsa)
        $aiNote = '';
        $apiKey = Yii::$app->params['anthropicApiKey'] ?? '';
        if ($apiKey) {
            try {
                $sys = "Sen arab tili talaffuz ustozisan. Foydalanuvchi qaysidir so'zni o'qidi. "
                     . "Maqsad so'z va eshitilgani beriladi. O'zbek tilida 1-2 jumlada qisqa, iliq maslahat ber. "
                     . "Faqat matn qaytar.";
                $usr = "Maqsad: {$target} (o'qilishi: {$targetRead}). Eshitilgani: {$heard}.";
                $ch = curl_init('https://api.anthropic.com/v1/messages');
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true,
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'x-api-key: ' . $apiKey, 'anthropic-version: 2023-06-01'],
                    CURLOPT_POSTFIELDS => json_encode([
                        'model' => 'claude-haiku-4-5-20251001', 'max_tokens' => 256,
                        'system' => $sys, 'messages' => [['role' => 'user', 'content' => $usr]],
                    ]),
                    CURLOPT_TIMEOUT => 20,
                ]);
                $raw = curl_exec($ch); curl_close($ch);
                $resp = json_decode($raw, true);
                $aiNote = trim($resp['content'][0]['text'] ?? '');
            } catch (\Throwable $e) { $aiNote = ''; }
        }

        if ($score >= 85)      $msg = "✅ Barakalla! To'g'ri o'qidingiz.";
        elseif ($score >= 55)  $msg = "🟡 Yaqin keldingiz — yana bir bor aniqroq urinib ko'ring.";
        else                   $msg = "🔴 Hozircha mos kelmadi. Avval audioni eshitib, qaytarib ko'ring.";

        return [
            'ok'    => $score >= 85,
            'score' => $score,
            'heard' => $heard,
            'msg'   => $aiNote ?: $msg,
        ];
    }

    /**
     * So'z tarkibi mashqi: so'zdagi harflarni aniqlash
     */
    public function actionWordQuiz()
    {
        $letters = ArabicLetter::getAllOrdered();
        // Harflardan namunali so'zlar to'plamini yaratamiz
        $words = [];
        foreach ($letters as $l) {
            $examples = $l->getExamples();
            foreach ($examples as $ex) {
                if (!empty($ex['ar'])) {
                    $words[] = [
                        'ar'     => $ex['ar'],
                        'uz'     => $ex['uz'] ?? '',
                        'letter' => $l->name_uz,
                        'trans'  => $l->transliteration,
                    ];
                }
            }
        }
        shuffle($words);
        $words = array_slice($words, 0, 40);
        return $this->render('word-quiz', [
            'letters' => $letters,
            'words'   => $words,
        ]);
    }
}
