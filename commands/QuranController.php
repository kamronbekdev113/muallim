<?php
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

/**
 * Quran ma'lumotlarini API dan yuklab, DB ga saqlaydi.
 * Ishlatish: php yii quran/fetch
 */
class QuranController extends Controller
{
    // Quran.com tajweed class → bizning CSS class
    private $tajweedMap = [
        'qalqalah'            => 'tj-qalqala',
        'ghunna'              => 'tj-ghunna',
        'madda_normal'        => 'tj-madd',
        'madda_permissible'   => 'tj-madd',
        'madda_necessary'     => 'tj-madd',
        'madda_obligatory'    => 'tj-madd',
        'ikhfa'               => 'tj-ikhfa',
        'ikhfa_shafawi'       => 'tj-ikhfa',
        'idgham_ghunna'       => 'tj-idgham',
        'idgham_wo_ghunna'    => 'tj-idgham',
        'idgham_shafawi'      => 'tj-idgham',
        'idgham_mutajanisayn' => 'tj-idgham',
        'idgham_mutaqaribayn' => 'tj-idgham',
        'iqlab'               => 'tj-iqlab',
        'izhar'               => 'tj-izhar',
        'izhar_shafawi'       => 'tj-izhar',
        'izhar_merging'       => 'tj-izhar',
        'lam_shamsiyya'       => 'tj-lam-shams',
        'laam_shamsiyah'      => 'tj-lam-shams',
        'ham_wasl'            => 'tj-hamza',
        'slnt'                => 'tj-silent',
    ];

    public function actionFetch($startSurah = 1, $endSurah = 114)
    {
        $startSurah = (int)$startSurah;
        $endSurah   = (int)$endSurah;

        $this->stdout("\n=== Quran ma'lumotlarini yuklash ($startSurah - $endSurah) ===\n\n");

        // 1. Barcha arabcha matn (Uthmani) ni bir qator yuklab olamiz
        $this->stdout("1) Arabcha Uthmani matn yuklanmoqda...\n");
        $arabicData = $this->fetchJson('https://api.alquran.cloud/v1/quran/quran-uthmani');
        if (!$arabicData || ($arabicData['status'] ?? '') !== 'OK') {
            $this->stderr("XATO: Arabcha matn yuklanmadi!\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }
        // Index by surah_number → ayah_number → text
        $arabicIndex = [];
        foreach ($arabicData['data']['surahs'] as $s) {
            foreach ($s['ayahs'] as $a) {
                $arabicIndex[$s['number']][$a['numberInSurah']] = $a['text'];
            }
        }
        $this->stdout("   OK. " . count($arabicData['data']['surahs']) . " sura yuklandi.\n");

        // 2. O'zbek tarjimasi
        $this->stdout("2) O'zbek tarjimasi yuklanmoqda...\n");
        $uzbekData = $this->fetchJson('https://api.alquran.cloud/v1/quran/uz.sodik');
        $uzbekIndex = [];
        if ($uzbekData && ($uzbekData['status'] ?? '') === 'OK') {
            foreach ($uzbekData['data']['surahs'] as $s) {
                foreach ($s['ayahs'] as $a) {
                    $uzbekIndex[$s['number']][$a['numberInSurah']] = $a['text'];
                }
            }
            $this->stdout("   OK. O'zbek tarjimasi yuklandi.\n");
        } else {
            $this->stdout("   OGOHLANTIRISH: O'zbek tarjimasi yuklanmadi, bo'sh qoladi.\n");
        }

        // 3. Transliteratsiya
        $this->stdout("3) Transliteratsiya yuklanmoqda...\n");
        $transData = $this->fetchJson('https://api.alquran.cloud/v1/quran/en.transliteration');
        $transIndex = [];
        if ($transData && ($transData['status'] ?? '') === 'OK') {
            foreach ($transData['data']['surahs'] as $s) {
                foreach ($s['ayahs'] as $a) {
                    $transIndex[$s['number']][$a['numberInSurah']] = $a['text'];
                }
            }
            $this->stdout("   OK. Transliteratsiya yuklandi.\n");
        } else {
            $this->stdout("   OGOHLANTIRISH: Transliteratsiya yuklanmadi.\n");
        }

        // 4. Har bir sura uchun tajweed HTML + DB ga yozish
        $this->stdout("4) Tajvid ranglari + DB ga yozish...\n");
        $db = Yii::$app->db;

        for ($surahNum = $startSurah; $surahNum <= $endSurah; $surahNum++) {
            $this->stdout("   Sura $surahNum...");

            // DB dagi sura ID sini topamiz
            $surahId = $db->createCommand(
                "SELECT id FROM {{%surah}} WHERE number = :n", [':n' => $surahNum]
            )->queryScalar();

            if (!$surahId) {
                $this->stdout(" TOPILMADI, o'tkazib yuborildi.\n");
                continue;
            }

            // Quran.com dan tajweed HTML ni yuklaymiz
            $tajweedIndex = [];
            $tajweedUrl = "https://api.quran.com/api/v4/quran/verses/uthmani_tajweed?chapter_number=$surahNum";
            $tajweedData = $this->fetchJson($tajweedUrl);
            if ($tajweedData && !empty($tajweedData['verses'])) {
                foreach ($tajweedData['verses'] as $v) {
                    // verse_key format: "1:7" — ikkinchi qism oyat raqami
                    $parts = explode(':', $v['verse_key'] ?? '');
                    $vNum  = isset($parts[1]) ? (int)$parts[1] : 0;
                    if ($vNum > 0) {
                        $tajweedIndex[$vNum] = $this->convertTajweedHtml(
                            $v['text_uthmani_tajweed'] ?? ''
                        );
                    }
                }
            }

            // Ayah'larni DB ga yozamiz
            $arabicSurah = $arabicIndex[$surahNum] ?? [];
            $uzbekSurah  = $uzbekIndex[$surahNum]  ?? [];
            $transSurah  = $transIndex[$surahNum]  ?? [];

            $inserted = 0;
            foreach ($arabicSurah as $ayahNum => $arabicText) {
                $exists = $db->createCommand(
                    "SELECT id FROM {{%ayah}} WHERE surah_id = :s AND number = :n",
                    [':s' => $surahId, ':n' => $ayahNum]
                )->queryScalar();

                $tajweedHtml    = $tajweedIndex[$ayahNum] ?? null;
                $translationUz  = $uzbekSurah[$ayahNum]  ?? null;
                $transliteration = $transSurah[$ayahNum] ?? null;

                if ($exists) {
                    $db->createCommand()->update('{{%ayah}}', [
                        'text_uthmani'   => $arabicText,
                        'text_tajweed'   => $tajweedHtml,
                        'translation_uz' => $translationUz,
                        'transliteration'=> $transliteration,
                    ], ['id' => $exists])->execute();
                } else {
                    $db->createCommand()->insert('{{%ayah}}', [
                        'surah_id'       => $surahId,
                        'number'         => $ayahNum,
                        'text_uthmani'   => $arabicText,
                        'text_tajweed'   => $tajweedHtml,
                        'translation_uz' => $translationUz,
                        'transliteration'=> $transliteration,
                        'juz'            => 1,
                        'page'           => 1,
                    ])->execute();
                    $inserted++;
                }
            }

            $count = count($arabicSurah);
            $this->stdout(" $count oyat ($inserted yangi)" . (empty($tajweedIndex) ? " [tajvidsiz]" : " [tajvidli]") . "\n");

            // API rate limit uchun kichik pauza
            usleep(150000); // 0.15 soniya
        }

        $this->stdout("\n✓ Tugadi!\n\n");
        return ExitCode::OK;
    }

    /**
     * Quran.com tajweed HTML class-larini bizning CSS class-larimizga o'giradi
     */
    private function convertTajweedHtml(string $html): string
    {
        if (empty($html)) return '';

        // <tajweed class=ham_wasl>X</tajweed> → <span class="tj-hamza">X</span>
        // class attribute quotes bo'lishi yoki bo'lmasligi mumkin
        $result = preg_replace_callback(
            '/<tajweed\s+class=["\']?([a-zA-Z_]+)["\']?\s*>/',
            function ($m) {
                $cls = trim($m[1]);
                $mapped = $this->tajweedMap[$cls] ?? '';
                return $mapped ? '<span class="' . $mapped . '">' : '<span>';
            },
            $html
        );
        $result = str_replace('</tajweed>', '</span>', $result);

        return $result;
    }

    private function fetchJson(string $url): ?array
    {
        $opts = [
            'http' => [
                'method'     => 'GET',
                'timeout'    => 30,
                'user_agent' => 'Mozilla/5.0 MuallimApp/1.0',
                'header'     => "Accept: application/json\r\n",
            ],
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ];
        $ctx = stream_context_create($opts);
        $raw = @file_get_contents($url, false, $ctx);
        if ($raw === false) return null;
        return json_decode($raw, true);
    }
}
