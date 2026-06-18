<?php
namespace app\models;

use yii\db\ActiveRecord;

class ArabicLetter extends ActiveRecord
{
    public static function tableName() { return '{{%arabic_letter}}'; }

    public function getExamples()
    {
        if (!$this->examples_json) return [];
        return json_decode($this->examples_json, true) ?? [];
    }

    /** Adashtiruvchi harflar bloki: ['kalit'=>'...', 'juftlar'=>[...]] yoki null */
    public function getConfusables()
    {
        if (empty($this->confusables)) return null;
        return json_decode($this->confusables, true) ?: null;
    }

    /** Harf SOZI (fa fi fu) — oldindan generatsiya qilingan lokal mp3 (yoki null) */
    public function soundUrl()
    {
        $cp = mb_ord($this->letter, 'UTF-8');
        if ($cp === false) return null;
        $hex = strtoupper(str_pad(dechex($cp), 4, '0', STR_PAD_LEFT));
        $f = \Yii::getAlias('@webroot') . '/audio/sounds/' . $hex . '.mp3';
        return is_file($f) ? ('@web/audio/sounds/' . $hex . '.mp3') : null;
    }

    /** So'z/iboraning oldindan generatsiya qilingan lokal ovozi (yoki null) */
    public static function wordAudio($ar)
    {
        $ar = (string)$ar;
        if ($ar === '') return null;
        $h = md5($ar);
        $f = \Yii::getAlias('@webroot') . '/audio/words/' . $h . '.mp3';
        return is_file($f) ? ('@web/audio/words/' . $h . '.mp3') : null;
    }

    /** Inson o'qigan harf ovozi (mp3) — codepoint bo'yicha. Mas. م → /audio/letters/0645.mp3 */
    public function audioUrl()
    {
        $cp = mb_ord($this->letter, 'UTF-8');
        if ($cp === false) return null;
        $hex = strtoupper(str_pad(dechex($cp), 4, '0', STR_PAD_LEFT));
        $file = \Yii::getAlias('@webroot') . '/audio/letters/' . $hex . '.mp3';
        return is_file($file) ? ('@web/audio/letters/' . $hex . '.mp3') : null;
    }

    /** Muallimi Soniy kitobining ushbu harf joylashgan asl sahifa rasmi (yoki null) */
    public function getBookPageImage()
    {
        if (empty($this->book_page)) return null;
        return sprintf('@web/img/muallim/p%02d.png', $this->book_page);
    }

    public static function getAllOrdered()
    {
        return static::find()->orderBy('sort_order ASC')->all();
    }

    /**
     * Ushbu harfga tegishli tajvid qoidalari belgilari.
     * Qaytaradi: [['key','label','desc','color'], ...]
     */
    public function ruleBadges()
    {
        $L = $this->letter;
        $badges = [];
        $in = function ($set) use ($L) { return mb_strpos($set, $L) !== false; };

        if ($in('قطبجد')) {
            $badges[] = ['qalqala', 'Qalqala', "Sokin (harakatsiz) bo'lganda yoki so'z oxirida bu harf SAKRAB, qaytarilib o'qiladi. Qalqala harflari: ق ط ب ج د. Misol: اَحَدْ → «ahad» dagi «d» sapchaydi; رَبّ → «rabb» dagi «b».", '#FFB300'];
        }
        if ($in('خصضغطقظ')) {
            $badges[] = ['mufaxxam', "Yo'g'on (isti'lo)", "Har doim YO'G'ON (qalin) — til orqasi ko'tarilib, og'iz to'lib chiqadi. Yo'g'on harflar: خ ص ض غ ط ق ظ. Misol: صَلَاة (so'lat), طَيِّب (toyyib) — «s/t» yumshoq emas, to'la.", '#8D6E63'];
        }
        if ($in('ءهعحغخ')) {
            $badges[] = ['izhar', 'Izhor (halqiy)', "Bo'g'iz harfi. Oldida sokin «n» (نْ) yoki tanvin kelsa — «n» ANIQ, yashirilmasdan o'qiladi. Misol: مِنْ خَيْرٍ → «min xayrin» («n» aniq eshitiladi).", '#90A4AE'];
        }
        if ($in('ينمول') || $in('ر')) {
            $badges[] = ['idgham', "Idg'om", "Oldidagi sokin «n»/tanvin shu harfga SINGIB, qo'shilib ketadi (harflar: ي ر م ل و ن — «yarmalun»). Misol: مِنْ رَبِّهِمْ → «mir-robbihim» («n» yo'qoladi).", '#BA68C8'];
        }
        if ($in('ب')) {
            $badges[] = ['iqlab', 'Iqlob', "Oldida sokin «n»/tanvin kelsa — «n» «m» ga AYLANADI. Misol: مِنْ بَعْدِ → «mim-ba'di».", '#EF9A9A'];
        }
        if ($in('تثجدذزسشصضطظفقك')) {
            $badges[] = ['ikhfa', 'Ixfo', "Oldida sokin «n»/tanvin kelsa — «n» burun bilan YASHIRIB (ixfo) o'qiladi (15 harfdan biri). Misol: مِنْ قَبْلُ → «n» tomoqda yashirinadi.", '#FFA726'];
        }
        if ($in('تثدذرزسشصضطظلن')) {
            $badges[] = ['shamsiy', 'Quyosh harfi', "«ال» (al-) qo'shilganda LOM o'qilMAYDI, bu harf qo'shaloq bo'ladi. Misol: الشَّمْس = «ash-shams» (al-shams emas).", '#FB8C00'];
        } else {
            $badges[] = ['qamariy', 'Oy harfi', "«ال» (al-) qo'shilganda LOM ANIQ o'qiladi. Misol: الْقَمَر = «al-qamar».", '#5C9EAD'];
        }
        return $badges;
    }

    /**
     * Harfning maxraji (chiqish o'rni). Qaytaradi: ['zone'=>key, 'title'=>..., 'desc'=>...]
     * zone diagrammada yoritiladigan soha kaliti.
     */
    public function makhrajInfo()
    {
        $map = [
            'ا' => ['throat_low', "Bo'g'iz tubi (havo)", "Ovoz bo'g'izning eng tubidan, ochiq havo bilan chiqadi."],
            'ه' => ['throat_low', "Bo'g'iz tubi", "Bo'g'iz tubidan yengil nafas bilan — oddiy «h»."],
            'ع' => ['throat_mid', "Bo'g'iz o'rtasi", "Bo'g'iz o'rtasi siqilib chiqadi — «ayn» (o'zbekchada yo'q)."],
            'ح' => ['throat_mid', "Bo'g'iz o'rtasi", "Bo'g'iz o'rtasidan issiq, kuchli nafas — «h»."],
            'غ' => ['throat_up', "Bo'g'iz yuqorisi", "Tomoq yuqorisidan g'arg'ara bilan — yo'g'on «g'»."],
            'خ' => ['throat_up', "Bo'g'iz yuqorisi", "Tomoq yuqorisidan — yo'g'on «x» (xona)."],
            'ق' => ['tongue_back', "Til eng orti", "Tilning ENG orti kichik til (tomoq) bilan — chuqur «q»."],
            'ك' => ['tongue_back', "Til orti", "Til orti yumshoq tanglayga — «k» (qof'dan oldinroq)."],
            'ج' => ['tongue_mid', "Til o'rtasi", "Til o'rtasi qattiq tanglayga tegib — «j»."],
            'ش' => ['tongue_mid', "Til o'rtasi", "Til o'rtasidan havo yoyilib — «sh»."],
            'ي' => ['tongue_mid', "Til o'rtasi", "Til o'rtasi tanglayga yaqin — «y»."],
            'ض' => ['tongue_edge', "Til yon tomoni", "Tilning YON tomoni yuqori oziq tishlarga bosiladi — eng qiyin harf."],
            'ل' => ['tongue_tip', "Til uchi (yon)", "Til uchining yoni yuqori milkka tegadi — «l»."],
            'ن' => ['tongue_tip', "Til uchi + burun", "Til uchi yuqori milkda, ovoz burundan ham — «n»."],
            'ر' => ['tongue_tip', "Til uchi (titroq)", "Til uchi tanglayga yengil urilib titraydi — «r»."],
            'ت' => ['tongue_teeth', "Til uchi + tishlar", "Til uchi yuqori tishlar yiltirog'iga — «t»."],
            'د' => ['tongue_teeth', "Til uchi + tishlar", "Til uchi yuqori tishlar yiltirog'iga — «d»."],
            'ط' => ['tongue_teeth', "Til uchi + tishlar", "Til uchi yuqori tishlarga, YO'G'ON — «t»."],
            'ص' => ['teeth_whistle', "Til uchi + tishlar (hushtak)", "Til uchi pastki tishlar orqasida, YO'G'ON hushtak — «s»."],
            'س' => ['teeth_whistle', "Til uchi + tishlar (hushtak)", "Til uchi pastki tishlar orqasida — ingichka «s» hushtagi."],
            'ز' => ['teeth_whistle', "Til uchi + tishlar (hushtak)", "Til uchi pastki tishlar orqasida, jarangli — «z»."],
            'ث' => ['between_teeth', "Til uchi tishlar orasida", "Til uchi tishlar orasidan chiqadi — «th» (think)."],
            'ذ' => ['between_teeth', "Til uchi tishlar orasida", "Til uchi tishlar orasida, jarangli — «th» (this)."],
            'ظ' => ['between_teeth', "Til uchi tishlar orasida", "Til uchi tishlar orasida, YO'G'ON — «z»."],
            'ف' => ['lip_teeth', "Pastki lab + tishlar", "Pastki lab yuqori tishlarga tegadi — «f»."],
            'ب' => ['lips', "Ikki lab", "Ikki lab yopilib ochiladi — «b»."],
            'م' => ['lips', "Ikki lab + burun", "Ikki lab yopiladi, ovoz burundan ham — «m»."],
            'و' => ['lips', "Lablar (yumaloq)", "Lablar yumaloqlanib chiqadi — «v/u»."],
        ];
        $z = $map[$this->letter] ?? ['throat_low', 'Maxraj', ''];
        return ['zone' => $z[0], 'title' => $z[1], 'desc' => $z[2]];
    }

    /**
     * Harakatli arab so'zining TAXMINIY o'zbekcha o'qilishi (beginner uchun yordam).
     * Asl talaffuz audio orqali — bu faqat ko'mak.
     */
    public static function reading($s)
    {
        $cons = [
            'ا' => '', 'أ' => '', 'إ' => '', 'آ' => 'o', 'ء' => '', 'ؤ' => '', 'ئ' => '',
            'ب' => 'b', 'ت' => 't', 'ث' => 's', 'ج' => 'j', 'ح' => 'h', 'خ' => 'x',
            'د' => 'd', 'ذ' => 'z', 'ر' => 'r', 'ز' => 'z', 'س' => 's', 'ش' => 'sh',
            'ص' => 's', 'ض' => 'd', 'ط' => 't', 'ظ' => 'z', 'ع' => 'ʼ', 'غ' => "g‘",
            'ف' => 'f', 'ق' => 'q', 'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
            'ه' => 'h', 'و' => 'v', 'ي' => 'y', 'ى' => 'a', 'ة' => 'h',
        ];
        $chars = preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY);
        $n = count($chars);
        $out = '';
        for ($i = 0; $i < $n; $i++) {
            $c = $chars[$i];
            if ($c === ' ' || $c === '-' || $c === '–') { $out .= $c; continue; }
            if (!isset($cons[$c])) continue; // diakritikani o'tkazib yuboramiz
            $base = $cons[$c];
            $shadda = false; $vowel = null; $tanwin = '';
            $j = $i + 1;
            while ($j < $n) {
                $d = $chars[$j];
                if ($d === 'ّ') { $shadda = true; $j++; continue; }
                if ($d === 'َ') { $vowel = 'a'; $j++; continue; }
                if ($d === 'ِ') { $vowel = 'i'; $j++; continue; }
                if ($d === 'ُ') { $vowel = 'u'; $j++; continue; }
                if ($d === 'ْ') { $vowel = '';  $j++; continue; }
                if ($d === 'ً') { $tanwin = 'an'; $j++; continue; }
                if ($d === 'ٍ') { $tanwin = 'in'; $j++; continue; }
                if ($d === 'ٌ') { $tanwin = 'un'; $j++; continue; }
                if ($d === 'ٰ') { $vowel = 'o'; $j++; continue; } // xanjar alif → uzun a
                break;
            }
            // ر tafxim (yo'g'on): fatha bilan «ro», tanvin fath bilan «ron»
            if ($c === 'ر') {
                if ($vowel === 'a') $vowel = 'o';
                if ($tanwin === 'an') $tanwin = 'on';
            }
            $piece = $shadda ? $base . $base : $base;
            if ($vowel !== null) $piece .= $vowel;
            $piece .= $tanwin;
            $out .= $piece;
            $i = $j - 1;
        }
        return trim($out);
    }
}
