<?php
use yii\db\Migration;

/**
 * Muallimi Soniy (arabic.uz, 2009) kitobiga AYNAN MOS harf seedi.
 *
 * - Harflar alifbo tartibida EMAS, kitobdagi o'rgatish tartibida (1-12 betlar).
 * - Har harf: harakat (fatha/kasra/damma) kirishi + kitobdagi mashq so'zlari
 *   (9-20 ta) + adashtiruvchi harf taqqoslari + asl kitob sahifa raqami.
 * - examples_json formati: [{"ar":"...","uz":"..."}] (uz ixtiyoriy).
 */
class m260618_120001_reseed_muallimi_letters extends Migration
{
    public function safeUp()
    {
        // --- Yangi ustunlar ---
        $cols = \Yii::$app->db->getTableSchema('{{%arabic_letter}}', true)->columnNames;
        if (!in_array('book_page', $cols)) {
            $this->addColumn('{{%arabic_letter}}', 'book_page', $this->smallInteger()->defaultValue(0));
        }
        if (!in_array('intro', $cols)) {
            $this->addColumn('{{%arabic_letter}}', 'intro', $this->string(60)->defaultValue(''));
        }
        if (!in_array('confusables', $cols)) {
            $this->addColumn('{{%arabic_letter}}', 'confusables', $this->text()->null());
        }
        if (!in_array('video_id', $cols)) {
            $this->addColumn('{{%arabic_letter}}', 'video_id', $this->string(20)->defaultValue(''));
        }

        // Shayx Alijon qori — Muallimi Soniy YouTube darslari (sort_order => video id)
        $videos = $this->videos();

        // --- Eski (umumiy alifbo) ma'lumotni tozalab, kitob tartibida qayta yozamiz ---
        $this->truncateTable('{{%arabic_letter}}');

        foreach ($this->letters() as $i => $l) {
            $this->insert('{{%arabic_letter}}', [
                'letter'             => $l['letter'],
                'name_uz'            => $l['name'],
                'transliteration'    => $l['tr'],
                'isolated'           => $l['forms'][0],
                'initial'            => $l['forms'][1],
                'medial'             => $l['forms'][2],
                'final'              => $l['forms'][3],
                'pronunciation_note' => $l['makhraj'],
                'examples_json'      => json_encode($this->words($l['words']), JSON_UNESCAPED_UNICODE),
                'intro'              => $l['intro'],
                'confusables'        => empty($l['conf']) ? null : json_encode($l['conf'], JSON_UNESCAPED_UNICODE),
                'book_page'          => $l['page'],
                'video_id'           => $videos[$i + 1] ?? '',
                'sort_order'         => $i + 1,
            ]);
        }
    }

    public function safeDown()
    {
        $this->truncateTable('{{%arabic_letter}}');
        foreach (['video_id', 'confusables', 'intro', 'book_page'] as $c) {
            try { $this->dropColumn('{{%arabic_letter}}', $c); } catch (\Throwable $e) {}
        }
    }

    /** sort_order (kitob tartibi) => Alijon qori YouTube video id */
    private function videos()
    {
        return [
            1  => 'DhbimE6IrSE', // alif — 3-dars (Harakatlar)
            2  => 'DhbimE6IrSE', // ро  — 3-dars (Harakatlar)
            3  => 'FZzftaWQTyI', // ز — 4-dars
            4  => '2QmOIb2ccsQ', // م — 5-dars
            5  => 'KyO6eXGA6R8', // ت — 6-dars
            6  => 'XLjL7clkdHQ', // ن — 7-dars
            7  => '8W6RCdU2Gic', // ي — 8-dars
            8  => 'Zt3sm6OVVKA', // ب — 9-dars
            9  => 'U9rvJqgDNdo', // ك — 10-dars
            10 => 'sqixgyn0Gwg', // ل — 11-dars
            11 => 'L4VMO_quJpw', // و — 12-dars
            12 => 'Tokv5xaAlv8', // ه — 13-dars
            13 => '3Xlmtj-EWIU', // ف — 14-dars
            14 => 'DsDgGa_2wAc', // ق — 15-dars
            15 => 'VNGn5wk3elg', // ش — 16-dars
            16 => '1XXwwlnkWrg', // س — 17-dars
            17 => '7AaBhJZBvWw', // ث — 18-dars
            18 => '4B1yxXu9hN4', // ص — 19-dars
            19 => 'jqOX4E9syoY', // ط — 20-dars
            20 => 'x9N8mj2y2WA', // ج — 21-dars
            21 => '-BLPANWCGS0', // خ — 22-dars
            22 => '7yC9HbSjatQ', // ح — 23-dars
            23 => 'mHQlHvVJqJk', // غ — 24-dars
            24 => 'he4ARple3Ik', // ع — 25-dars
            25 => 'eyE2G0zbg_Y', // د — 26-dars
            26 => '79aOWJrV3Mc', // ض — 27-dars
            27 => 'qcUSKykCKBE', // ذ — 28-dars
            28 => 'aFHmynG8vQ0', // ظ — 29-dars
        ];
    }

    /** "زَرْ مُزْ" kabi so'z ro'yxatini examples_json elementlariga aylantiradi */
    private function words(array $list)
    {
        $out = [];
        foreach ($list as $w) {
            if (is_array($w)) {
                $out[] = ['ar' => $w[0], 'uz' => $w[1]];
            } else {
                $out[] = ['ar' => $w, 'uz' => ''];
            }
        }
        return $out;
    }

    /**
     * Kitob tartibidagi 28 harf.
     * forms = [yakka, boshida, o'rtada, oxirida]
     */
    private function letters()
    {
        return [
            [
                'letter' => 'ا', 'name' => 'Alif', 'tr' => 'a/i/u', 'page' => 1,
                'forms' => ['ا', 'ا', 'ـا', 'ـا'], 'intro' => 'اَ اِ اُ',
                'makhraj' => "Unli tayanchi. Ustida fatha — «a», ostida kasra — «i», ustida damma — «u» o'qiladi. O'zi mustaqil tovushi yo'q.",
                'words' => ['اَ', 'اِ', 'اُ'],
            ],
            [
                'letter' => 'ر', 'name' => 'Ro', 'tr' => 'r', 'page' => 1,
                'forms' => ['ر', 'ر', 'ـر', 'ـر'], 'intro' => 'رَ رِ رُ',
                'makhraj' => "Til uchi yuqori tanglayga yengil tegib, «r» titraydi (o'zbekcha «r» kabi). و va ز bilan birikadi, lekin keyingi harf bilan bog'lanmaydi.",
                'words' => ['رَ', 'رِ', 'رُ', 'اَرْ', 'اِرْ', 'اُرْ'],
            ],
            [
                'letter' => 'ز', 'name' => 'Zay', 'tr' => 'z', 'page' => 1,
                'forms' => ['ز', 'ز', 'ـز', 'ـز'], 'intro' => 'زَ زِ زُ',
                'makhraj' => "O'zbekcha «z» kabi, til uchi pastki tishlarga yaqin. Keyingi harf bilan bog'lanmaydi.",
                'words' => ['زَ', 'زِ', 'زُ', 'اَزْ', 'اِزْ', 'اُزْ', 'زَرْ', 'زِرْ', 'زُرْ', 'اَزْرُ', 'اِزْرُ', 'اُزْرُ', 'اَرْزُ', 'اِرْزُ', 'اُرْزُ'],
            ],
            [
                'letter' => 'م', 'name' => 'Mim', 'tr' => 'm', 'page' => 2,
                'forms' => ['م', 'مـ', 'ـمـ', 'ـم'], 'intro' => 'مَ مِ مُ',
                'makhraj' => "Ikki lab yopilib «m» chiqadi (o'zbekcha «m» kabi).",
                'words' => ['مَ', 'مِ', 'مُ', 'اَمْ', 'اِمْ', 'اُمْ', 'مُزْ', 'مُرْ', 'رُمْ', 'اَمَرَ', 'اَمِرَ', 'اَمْرُ', 'اِمْرُ', 'رَمْزُ', 'اِرْمِ', 'مَرْمَرْ', 'رَمْرَمْ', ['زَمْزَمْ', 'Zamzam'], 'اَرْزَمْ'],
            ],
            [
                'letter' => 'ت', 'name' => 'Ta', 'tr' => 't', 'page' => 2,
                'forms' => ['ت', 'تـ', 'ـتـ', 'ـت'], 'intro' => 'تَ تِ تُ',
                'makhraj' => "Til uchi yuqori tishlar ortiga tegadi — yumshoq «t» (o'zbekcha «t»).",
                'words' => ['تَ', 'تِ', 'تُ', 'مَتْ', 'مِتْ', 'مُتْ', 'تَمَرْ', 'تَرِرْ', 'مَرَرْتُ', 'اَمِرْتُ', 'اَمَرَتْ', 'اَمَرْتُمْ', 'اُمِرْتُمْ', 'مَرَرْتُمْ', 'مُرِرْتُمْ'],
            ],
            [
                'letter' => 'ن', 'name' => 'Nun', 'tr' => 'n', 'page' => 2,
                'forms' => ['ن', 'نـ', 'ـنـ', 'ـن'], 'intro' => 'نَ نِ نُ',
                'makhraj' => "Til uchi yuqori tanglayda, tovush burundan chiqadi — «n».",
                'words' => ['نَ', 'نِ', 'نُ', 'اَنْ', 'اِنْ', ['مِنْ', 'dan'], ['مَنْ', 'kim'], 'زِنْ', 'نَمْ', ['اَنْتَ', 'sen'], 'نِمْتَ', ['اَنْتُمْ', 'sizlar'], 'نِمْتُمْ', 'نَزَرُ', 'نَزُنُ', 'اَمَرْنَ', 'اُمِرْنَ', 'مَرَرْنَ', 'مُرِرْنَ'],
            ],
            [
                'letter' => 'ي', 'name' => 'Ya', 'tr' => 'y/iy', 'page' => 3,
                'forms' => ['ي', 'يـ', 'ـيـ', 'ـي'], 'intro' => 'يَ يِ ى',
                'makhraj' => "O'zbekcha «y»; kasradan keyin sokin kelsa uzun «iy» bo'lib cho'ziladi.",
                'words' => ['يَ', 'يِ', 'ى', 'اَىْ', 'اَيْمُ', 'زَيْتُ', 'مَيْتُ', 'رَاْى', 'رَمْىُ', ['يَمَنْ', 'Yaman'], ['مَرْيَمْ', 'Maryam'], 'مَيْزَرْ', 'مَيْمَنْ', 'اَيْمَنْ', 'اَمْرَيْنِ', 'زَيْتَيْنِ', 'اَيْمَيْنِ', 'مَيْتَيْنِ'],
            ],
            [
                'letter' => 'ب', 'name' => 'Ba', 'tr' => 'b', 'page' => 3,
                'forms' => ['ب', 'بـ', 'ـبـ', 'ـب'], 'intro' => 'بَ بِ بُ',
                'makhraj' => "Ikki lab yopilib «b» chiqadi. Tagida bitta nuqta.",
                'words' => ['بَ', 'بِ', 'بُ', 'اَبْ', ['اِبْنُ', "o'g'il"], ['بِنْتُ', 'qiz'], ['بَيْتُ', 'uy'], 'بَيْنُ', 'رَيْبُ', ['زَيْنَبْ', 'Zaynab'], 'بَرْبَرْ', 'بَيْرَمْ', 'اَبْرَمْ', ['مِنْبَرْ', 'minbar'], 'بِاَمْرَيْنِ', 'بِبَيْتَيْنِ', 'مِنْبَرَيْنِ', 'زَيْنَبَيْنِ'],
            ],
            [
                'letter' => 'ك', 'name' => 'Kaf', 'tr' => 'k', 'page' => 3,
                'forms' => ['ك', 'كـ', 'ـكـ', 'ـك'], 'intro' => 'كَ كِ كُ',
                'makhraj' => "Til orti yumshoq tanglayga tegib «k» (o'zbekcha «k»). Yozma shakli «ک» ham bo'ladi.",
                'words' => ['كَ', 'كِ', 'كُ', 'كَمْ', 'كُمْ', 'كُنْ', 'كَيْ', 'بَكْرُ', 'مَكْرُ', 'كَرْمُ', 'كَنْزُ', 'تَرْكُ', ['كَتَبَ', 'yozdi'], ['يَكْتُبْ', 'yozadi'], ['تَرَكَ', 'tark etdi'], 'يَتْرُكُ', 'كَتَبْتُمْ', 'اَمَرَكَ', 'اَمَرْتُكَ', 'كُنْتُ', ['مُمْكِنْ', 'mumkin']],
            ],
            [
                'letter' => 'ل', 'name' => 'Lam', 'tr' => 'l', 'page' => 4,
                'forms' => ['ل', 'لـ', 'ـلـ', 'ـل'], 'intro' => 'لَ لِ لُ',
                'makhraj' => "Til uchi yuqori milkka (old tishlar ortiga) tegib «l».",
                'words' => ['لَ', 'لِ', 'لُ', 'اَلْ', ['بَلْ', 'balki'], 'لَمْ', 'لُمْ', 'لَنْ', 'كِلْ', ['نَزَلَ', 'tushdi'], 'لَزِمَ', 'كَمُلَ', 'اَنْزَلَ', 'اَلْزَمَ', 'اَكْمَلَ', 'اَكَلَتْ', 'اَكَلْنَ', 'اَكَلْتَ', 'اَكَلْتِ', 'اَكَلْتُ', 'اَكَلْتُمْ', ['بُلْبُلْ', 'bulbul'], 'يَلَمْلَمْ', 'تَزَلْزَلَ', 'يَتَزَلْزَلُ', 'مُتَزَلْزِلْ'],
            ],
            [
                'letter' => 'و', 'name' => 'Vov', 'tr' => 'v/w/uu', 'page' => 4,
                'forms' => ['و', 'و', 'ـو', 'ـو'], 'intro' => 'وَ وِ وُ',
                'makhraj' => "Lablar yumaloqlanib «v/w»; dammadan keyin sokin kelsa uzun «uu» bo'ladi. Keyingi harf bilan bog'lanmaydi.",
                'words' => ['وَ', 'وِ', 'وُ', 'اَوْ', 'رَوْ', 'نَوْ', 'لَوْ', 'وَرَمْ', 'وَتَرْ', ['وَمَنْ', 'va kim'], 'وَلَنْ', 'وَلَمْ', 'وَكَمْ', 'اَوْلُ', 'رَوْمُ', ['يَوْمُ', 'kun'], 'كَوْنُ', 'وَيْلُ', 'وَزْنُ', ['كَوْكَبْ', 'yulduz'], 'مَوْكِبْ', 'اَوْلَمْتُمْ', 'اَوْتَرْتُمْ'],
            ],
            [
                'letter' => 'ه', 'name' => 'Ha (yumshoq)', 'tr' => 'h', 'page' => 5,
                'forms' => ['ه', 'هـ', 'ـهـ', 'ـه'], 'intro' => 'هَ هِ هُ',
                'makhraj' => "Bo'g'izning eng tubidan yengil nafas bilan chiqadigan oddiy «h» (o'zbekcha «h»).",
                'words' => ['هَ', 'هِ', 'هُ', 'هَبْ', 'هَمْ', ['هَلْ', 'mi?'], ['هُوَ', 'u (erkak)'], ['هِيَ', 'u (ayol)'], ['هُمْ', 'ular'], 'زُهْ', 'اَهَمْ', ['وَهَبْ', 'in etdi'], ['لَهَبْ', 'olov'], 'وَهَمْ', ['لَهُمْ', 'ularga'], ['بِهِمْ', 'ular bilan'], ['مِنْهُ', 'undan'], ['مِنْهُمْ', 'ulardan'], ['اِلَيْهِ', 'unga'], ['اِلَيْهِمْ', 'ularga'], 'اَمْهَلْهُمْ'],
            ],
            [
                'letter' => 'ف', 'name' => 'Fa', 'tr' => 'f', 'page' => 5,
                'forms' => ['ف', 'فـ', 'ـفـ', 'ـف'], 'intro' => 'فَ فِ فُ',
                'makhraj' => "Yuqori tishlar pastki labga tegib «f». Ustida bitta nuqta.",
                'words' => ['فَ', 'فِ', 'فُ', 'فَمْ', 'فَنْ', 'كَفْ', ['فَلَكْ', 'falak'], ['كَفَنْ', 'kafan'], ['نَفَرْ', 'nafar'], 'فَوْرُ', ['فَوْزُ', 'g\'alaba'], ['فَهْمُ', 'tushunish'], ['فِكْرُ', 'fikr'], 'زِفْرُ', 'كِفْلُ', 'فُلْفُلْ', 'نَوْفَرْ', 'نَوْفَلْ', ['فَهِمَ', 'tushundi'], ['يَفْهَمُ', 'tushunadi'], 'اِفْهَمْ', 'اِفْتَتَنَ', 'يَفْتَتِنُ', 'اِفْتَكَرَ', 'يَفْتَكِرُ'],
            ],
            [
                'letter' => 'ق', 'name' => 'Qof', 'tr' => 'q', 'page' => 6,
                'forms' => ['ق', 'قـ', 'ـقـ', 'ـق'], 'intro' => 'قَ قِ قُ',
                'makhraj' => "Tilning eng orti tomoq (kichik til) bilan — chuqur, qattiq «q». «k» dan ancha orqaroqdan chiqadi.",
                'words' => ['قَ', 'قِ', 'قُ', 'زُقْ', 'قِنْ', 'قِلْ', ['قُلْ', 'ayt'], ['قُمْ', 'tur'], 'قِفْ', 'قِهْ', ['قَلْبُ', 'qalb'], ['قَبْلُ', 'oldin'], ['فَوْقُ', 'ustida'], ['قَلَمْ', 'qalam'], ['قَمَرْ', 'oy'], ['لَقَبْ', 'laqab'], 'قُمْقُمْ', 'اِقْتَرَبَ', 'يَقْتَرِبُ', 'اِنْقَلَبَ', 'يَنْقَلِبُ'],
                'conf' => ['kalit' => 'ك (yumshoq) ↔ ق (chuqur)', 'juftlar' => ['كَدَرْ – قَدَرْ', 'فَلَكْ – فَلَقْ', 'فَرْكُ – فَرْقُ']],
            ],
            [
                'letter' => 'ش', 'name' => 'Shin', 'tr' => 'sh', 'page' => 6,
                'forms' => ['ش', 'شـ', 'ـشـ', 'ـش'], 'intro' => 'شَ شِ شُ',
                'makhraj' => "O'zbekcha «sh». Ustida uchta nuqta.",
                'words' => ['شَ', 'شِ', 'شُ', 'رَشْ', 'بُشْ', 'شَرْ', 'شَقْ', 'شَمْ', 'شَكْ', 'بِشْرُ', 'شِرْبَ', ['شَهْرُ', 'oy (vaqt)'], 'نَشْرُ', ['شُكْرُ', 'shukr'], ['شُرْبُ', 'ichish'], 'مَشْرَبْ', 'مَشْرِبْ', ['مَشْرِقْ', 'sharq'], 'مُشْتَهِرْ', ['مُشْتَرَكْ', 'mushtarak'], 'اِشْتَهَرَ', 'يَشْتَهِرُ', 'اِبْرَنْشَقَ', 'يَبْرَنْشِقُ'],
            ],
            [
                'letter' => 'س', 'name' => 'Sin', 'tr' => 's', 'page' => 7,
                'forms' => ['س', 'سـ', 'ـسـ', 'ـس'], 'intro' => 'سَ سِ سُ',
                'makhraj' => "O'zbekcha ingichka «s».",
                'words' => ['سَ', 'سِ', 'سُ', 'بَسْ', 'سَمْ', ['سِرْ', 'sir'], 'سِنْ', 'سِلْ', ['سَفَرْ', 'safar'], 'سَقَرْ', ['سَبَقْ', 'o\'zib ketdi'], 'سَلَفْ', ['سَمَكْ', 'baliq'], ['فَرَسْ', 'ot'], 'مَسْلَكْ', ['مَسْكَنْ', 'maskan'], ['مُسْلِمْ', 'musulmon'], 'مُسْرِفْ', ['سِمْسِمْ', 'kunjut'], ['اَسْلَمَ', 'islom keltirdi'], 'يُسْلِمُ', 'اِسْتَيْسَرَ', 'يَسْتَيْسِرُ'],
            ],
            [
                'letter' => 'ث', 'name' => 'Sa', 'tr' => 'th', 'page' => 7,
                'forms' => ['ث', 'ثـ', 'ـثـ', 'ـث'], 'intro' => 'ثَ ثِ ثُ',
                'makhraj' => "Til uchi tishlar orasiga chiqib chiqadigan «th» (inglizcha «think»dagi kabi). Ustida uchta nuqta.",
                'words' => ['ثَ', 'ثِ', 'ثُ', 'بَثْ', 'ثِبْ', 'ثَمْ', 'ثِنْ', ['ثَمَرْ', 'meva'], ['ثَمَنْ', 'narx'], ['ثَوْرُ', 'ho\'kiz'], ['ثَوْبُ', 'kiyim'], 'ثَيْبُ', ['مِثْلُ', 'kabi'], 'مُثْلُ', ['مَثَلْ', 'masal'], ['كَوْثَرْ', 'Kavsar'], ['اَكْثَرَ', 'ko\'paytirdi'], 'يُكْثِرُ', ['اَثْبَتَ', 'isbotladi'], 'يُثْبِتُ', 'اِسْتَكْثَرَ', 'يَسْتَكْثِرُ', 'اِسْتَثْقَلَ', 'يَسْتَثْقِلُ'],
                'conf' => ['kalit' => 'س (ingichka s) ↔ ث (th)', 'juftlar' => ['سَمَرْ – ثَمَرْ', 'سَبْتُ – ثَبْتُ', 'سَلْسُ – ثَلْثُ']],
            ],
            [
                'letter' => 'ص', 'name' => 'Sod', 'tr' => 'ş (qalin s)', 'page' => 8,
                'forms' => ['ص', 'صـ', 'ـصـ', 'ـص'], 'intro' => 'صَ صِ صُ',
                'makhraj' => "Qalin (yo'g'on) «s» — og'iz to'lib, til orqa tomonga ko'tarilib chiqadi. «s» dan yo'g'onroq.",
                'words' => ['صَ', 'صِ', 'صُ', 'صُمْ', 'صِفْ', 'فَصْ', ['صَرَفْ', 'sarfladi'], ['صَبَرْ', 'sabr qildi'], ['بَصَرْ', 'ko\'rish'], 'قَصَبْ', ['نَصَرَ', 'yordam berdi'], 'يَنْصُرُ', 'اِسْتَبْصَرَ', 'يَسْتَبْصِرُ'],
                'conf' => ['kalit' => 'س (ingichka) ↔ ص (qalin)', 'juftlar' => ['سَفَرْ – صَفَرْ', 'سَيْفُ – صَيْفُ', 'اِنْتَسَبَ – اِنْتَصَبَ']],
            ],
            [
                'letter' => 'ط', 'name' => 'To (qalin)', 'tr' => 'ţ (qalin t)', 'page' => 8,
                'forms' => ['ط', 'طـ', 'ـطـ', 'ـط'], 'intro' => 'طَ طِ طُ',
                'makhraj' => "Qalin (yo'g'on) «t» — til orqa tanglayga ko'tariladi, tovush to'lib chiqadi.",
                'words' => ['طَ', 'طِ', 'طُ', 'طَلْ', 'طَىْ', 'شَطْ', 'بَطْ', 'قَطْ', ['فَقَطْ', 'faqat'], ['وَطَنْ', 'vatan'], ['طَلَبْ', 'talab'], ['طَرَفْ', 'taraf'], 'طُهُرْ', ['طِفْلُ', 'go\'dak'], ['مَطَرْ', 'yomg\'ir'], 'مَطْلَبْ', 'مَسْقَطْ', ['مَوْطِنْ', 'vatan'], 'مَرْبِطْ', 'اِصْطَبَرَ', 'يَصْطَبِرُ', 'اِسْتَوْطَنَ', 'يَسْتَوْطِنُ'],
                'conf' => ['kalit' => 'ت (yumshoq) ↔ ط (qalin)', 'juftlar' => ['تَرَفْ – طَرَفْ', 'سَبْتُ – سَبْطُ', 'مُسْتَتِرْ – مُسْتَطِرْ']],
            ],
            [
                'letter' => 'ج', 'name' => 'Jim', 'tr' => 'j', 'page' => 9,
                'forms' => ['ج', 'جـ', 'ـجـ', 'ـج'], 'intro' => 'جَ جِ جُ',
                'makhraj' => "O'zbekcha «j» (jurnal). Tagida bitta nuqta.",
                'words' => ['جَ', 'جِ', 'جُ', 'جَمْ', 'جَرْ', 'جِنْ', 'جَبْ', 'جُلْ', ['جَبَلْ', 'tog\''], ['جَمَلْ', 'tuya'], ['اَجْرُ', 'ajr'], ['فَجْرُ', 'tong'], ['جَوْهَرْ', 'javohir'], ['جَوْرَبْ', 'paypoq'], 'تَجَوْرَبَ', 'يَتَجَوْرَبُ', 'اِسْتَجْلَبَ', 'يَسْتَجْلِبُ'],
            ],
            [
                'letter' => 'خ', 'name' => 'Xa', 'tr' => 'x', 'page' => 9,
                'forms' => ['خ', 'خـ', 'ـخـ', 'ـخ'], 'intro' => 'خَ خِ خُ',
                'makhraj' => "O'zbekcha «x» (xona) — tomoqning yuqorisidan. Ustida bitta nuqta.",
                'words' => ['خَ', 'خِ', 'خُ', 'خَبْ', 'خَلْ', ['خَرَجْ', 'chiqdi'], ['خَبَرْ', 'xabar'], ['خَشَبْ', 'yog\'och'], 'خَلَفْ', ['خَيْرُ', 'yaxshilik'], ['خَتْمُ', 'tugatish'], ['خَمْرُ', 'may'], ['خَوْفُ', 'qo\'rquv'], 'مَخْرَجْ', 'مُخْبِرْ', ['اَخْرَجَ', 'chiqardi'], 'يُخْرِجُ', ['اَخْبَرَ', 'xabar berdi'], 'يُخْبِرُ', 'اِسْتَخْبَرَ', 'يَسْتَخْبِرُ', 'اِسْتَخْرَجَ', 'يَسْتَخْرِجُ'],
            ],
            [
                'letter' => 'ح', 'name' => 'Ha (kuchli)', 'tr' => 'ḥ', 'page' => 9,
                'forms' => ['ح', 'حـ', 'ـحـ', 'ـح'], 'intro' => 'حَ حِ حُ',
                'makhraj' => "Bo'g'iz O'RTASIDAN issiq, kuchli nafas bilan chiqadigan «h». Oddiy «ه» dan farqli — chuqurroq va kuchliroq.",
                'words' => ['حَ', 'حِ', 'حُ', 'حَى', 'حِلْ', ['حَجْ', 'haj'], ['حَسَنْ', 'go\'zal'], ['حَسَبْ', 'hisob'], ['حَسَدْ', 'hasad'], ['مُحْسِنْ', 'ehson qiluvchi'], ['مَحْشَرْ', 'mahshar'], 'مِنْحَرْ', ['مَحْفَلْ', 'mahfil'], ['اَحْسَنْ', 'eng yaxshi'], 'اِمْتَحَنَ', 'يَمْتَحِنُ', 'اِحْتَمَلَ', 'يَحْتَمِلُ', 'اِسْتَحْسَنَ', 'يَسْتَحْسِنُ', 'اِحْرَنْجَمَ', 'يَحْرَنْجِمُ'],
                'conf' => ['kalit' => 'خ (x) ↔ ح (kuchli h)', 'juftlar' => ['خَلْقُ – حَلْقُ', 'خَتْمُ – حَتْمُ', 'اَرْخَمْ – اَرْحَمْ']],
            ],
            [
                'letter' => 'غ', 'name' => "G'ayn", 'tr' => 'ğ', 'page' => 10,
                'forms' => ['غ', 'غـ', 'ـغـ', 'ـغ'], 'intro' => 'غَ غِ غُ',
                'makhraj' => "Tomoqning yuqorisidan «g'» — frantsuzcha «r» kabi yo'g'on, g'arg'ara tovushi. Ustida bitta nuqta.",
                'words' => ['غَ', 'غِ', 'غُ', 'غَمْ', 'غَبْ', 'غِلْ', ['غَيْرْ', 'boshqa'], ['بَغْلُ', 'xachir'], 'فَرْغُ', 'غَبْغَبْ', ['مَبْلَغْ', 'mablag\''], ['مَغْرِبْ', 'g\'arb'], 'اِغْلِبْ', ['اِغْفِرْ', 'kechir'], 'اِشْتَغَلَ', 'يَشْتَغِلُ', 'اِسْتَغْفَرَ', 'يَسْتَغْفِرُ'],
            ],
            [
                'letter' => 'ع', 'name' => 'Ayn', 'tr' => 'ʿ', 'page' => 10,
                'forms' => ['ع', 'عـ', 'ـعـ', 'ـع'], 'intro' => 'عَ عِ عُ',
                'makhraj' => "Bo'g'iz O'RTASI siqilib chiqadigan maxsus tovush — o'zbekchada yo'q. ح ning jarangli jufti, tomoqdan «a'» kabi.",
                'words' => ['عَ', 'عِ', 'عُ', ['بِعْ', 'sot'], ['عَنْ', 'haqida'], 'عَمْ', 'سَعْ', ['مَعَ', 'bilan'], ['عَرَبَ', 'arab'], ['عَجَمْ', 'ajam'], ['عَجَبْ', 'ajab'], ['عَمَلْ', 'amal'], ['عِلْمُ', 'ilm'], ['عُمْرُ', 'umr'], ['جَمْعُ', 'jamlash'], 'جَعَلُ', 'عَبْعَبْ', ['عَسْكَرْ', 'askar'], 'عَيْلَمْ', ['جَعْفَرْ', 'Ja\'far'], ['عَنْبَرْ', 'anbar']],
                'conf' => ['kalit' => "غ (g') ↔ ع (ayn)", 'juftlar' => ['غَيْنُ – عَيْنُ', 'بَغْلُ – بَعْلُ', 'بَلْغُ – بَلْعُ']],
            ],
            [
                'letter' => 'د', 'name' => 'Dal', 'tr' => 'd', 'page' => 11,
                'forms' => ['د', 'د', 'ـد', 'ـد'], 'intro' => 'دَ دِ دُ',
                'makhraj' => "Til uchi yuqori tishlar ortiga tegib «d». Keyingi harf bilan bog'lanmaydi.",
                'words' => ['دَ', 'دِ', 'دُ', 'دُمْ', 'دُبْ', 'دُفْ', 'رِدْ', ['زِدْ', 'ko\'paytir'], 'تَدْ', ['دَرْسُ', 'dars'], ['دَفْعُ', 'itarish'], 'دَبْغُ', 'دَلْكُ', ['دَهْرُ', 'zamon'], 'دُهْنُ', 'دُلْدُلْ', 'فُدْفُدْ', ['هُدْهُدْ', 'hudhud'], 'اُشْدُدْ', 'اِعْتَدَلَ', 'يَعْتَدِلُ', 'اِسْتَرْشَدَ', 'يَسْتَرْشِدُ'],
            ],
            [
                'letter' => 'ض', 'name' => 'Zod', 'tr' => 'ḍ (qalin)', 'page' => 11,
                'forms' => ['ض', 'ضـ', 'ـضـ', 'ـض'], 'intro' => 'ضَ ضِ ضُ',
                'makhraj' => "Arabchaning eng qiyin tovushi. Tilning yon TOMONI yuqori ozic (oziq) tishlarga bosilib, qalin «d/z» chiqadi.",
                'words' => ['ضَ', 'ضِ', 'ضُ', ['ضَيْفُ', 'mehmon'], 'عَضْلُ', 'ضَهْبُ', 'ضَبْطُ', ['ضَعْفُ', 'zaiflik'], ['عَرْضُ', 'kenglik'], 'مَضْرِبْ', 'مِضْرَبْ', ['اِضْرِبْ', 'ur'], 'تَضْرِبُ', 'اَضْرِبُ', 'نَضْرِبُ', 'اِضْطَرَبَ', 'يَضْطَرِبُ', 'اِسْتَضْعَفَ', 'يَسْتَضْعِفُ'],
                'conf' => ['kalit' => 'د (d) ↔ ض (qalin) ', 'juftlar' => ['دَرْسُ – ضَرْسُ', 'وَدْعُ – وَضْعُ', 'بَعْدُ – بَعْضُ']],
            ],
            [
                'letter' => 'ذ', 'name' => 'Zal', 'tr' => 'ẕ (th)', 'page' => 12,
                'forms' => ['ذ', 'ذ', 'ـذ', 'ـذ'], 'intro' => 'ذَ ذِ ذُ',
                'makhraj' => "Til uchi tishlar orasiga chiqib, jarangli «th» (inglizcha «this»dagi kabi). Ustida bitta nuqta. Keyingi harf bilan bog'lanmaydi.",
                'words' => ['ذَ', 'ذِ', 'ذُ', ['اِذْ', 'o\'shanda'], 'مُذْ', ['خُذْ', 'ol'], 'عُذْ', 'ذُبْ', 'ذُقْ', 'ذَرْ', ['مُنْذُ', 'beri'], ['اِذْنُ', 'ruxsat'], 'بَذْلُ', ['ذِكْرُ', 'zikr'], ['ذِهْنُ', 'zehn'], ['ذَهَبْ', 'oltin'], ['مَذْهَبْ', 'mazhab'], 'ذَهَلَ', 'يَذْهَلُ', ['بَذَلَ', 'sarf qildi'], 'يَبْذُلُ', ['اَذْهَبَ', 'ketkazdi'], 'يُذْهِبُ'],
                'conf' => ['kalit' => 'ز (z) ↔ ذ (th)', 'juftlar' => ['ذِفْرُ – زِفْرُ', 'اَبْذَلْ – اَبْزَلْ']],
            ],
            [
                'letter' => 'ظ', 'name' => 'Zo (qalin)', 'tr' => 'ẓ (qalin)', 'page' => 12,
                'forms' => ['ظ', 'ظـ', 'ـظـ', 'ـظ'], 'intro' => 'ظَ ظِ ظُ',
                'makhraj' => "Qalin (yo'g'on) «z» — til uchi tishlar orasida, ص/ض oilasidan. ذ ning yo'g'on jufti.",
                'words' => ['ظَ', 'ظِ', 'ظُ', ['ظَنْ', 'gumon'], ['ظِلْ', 'soya'], 'قَظْ', 'حَظْ', 'عَظْ', 'لَظْ', ['ظَفَرْ', 'zafar'], ['نَظَرْ', 'nazar'], 'ظَمَرْ', 'حَظَرْ', 'ظَلَفْ', ['عِظَمْ', 'ulug\'lik'], ['نَظْمُ', 'tartib'], 'ظِلْفُ', ['ظُلْمُ', 'zulm'], ['ظُهْرُ', 'peshin'], 'اَظْهَرْ', 'مَنْظَرْ', ['مُظْلِمْ', 'qorong\'i'], ['ظَهَرَ', 'paydo bo\'ldi'], 'يَظْهَرُ', ['نَظَرَ', 'qaradi'], 'يَنْظُرُ', ['ظَلَمَ', 'zulm qildi'], 'يَظْلِمُ', 'اِنْتَظَمَ', 'يَنْتَظِمُ', 'اِسْتَعْظَمَ', 'يَسْتَعْظِمُ'],
                'conf' => ['kalit' => 'ذ/ز/ض ↔ ظ (qalin z)', 'juftlar' => ['ذَفَرْ – ظَفَرْ', 'حَظَرْ – حَضَرْ', 'ظَهْرُ – ضَهْرُ', 'اَزْهَرْ – اَظْهَرْ', 'اَعْزَمْ – اَعْظَمْ']],
            ],
        ];
    }
}
