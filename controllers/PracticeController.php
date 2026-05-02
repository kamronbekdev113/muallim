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
