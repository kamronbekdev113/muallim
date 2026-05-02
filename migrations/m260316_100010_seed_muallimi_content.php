<?php
use yii\db\Migration;

class m260316_100010_seed_muallimi_content extends Migration
{
    public function up()
    {
        // === BOBLAR ===
        $chapters = [
            [1, 'Alifbo asoslari', 'Arab alifbosining 28 harfi: shakllari, o\'qilishi va yozilishi', 'font', 1],
            [2, 'Harakatlar (Harakat)', 'Fatha (a), Kasra (i), Damma (u) — qisqa unlilar', 'star', 2],
            [3, 'Tanvin', 'Tanvini fath, tanvini kasr, tanvini damm — -an, -in, -un', 'circle', 3],
            [4, 'Sukun va Shaddah', 'Sukun (sokin harf), Shaddah (qo\'shilgan harf)', 'layer-group', 4],
            [5, 'Madd (Cho\'ziq unlilar)', 'Alif madd (ā), Vav madd (ū), Ya madd (ī)', 'arrows-left-right', 5],
            [6, "So'z o'qish mashqlari", "Muallimi Soniy asosi: bo'g'in va so'z o'qish", 'book-open', 6],
            [7, 'Tajvid asoslari', 'Qalqala, Nun sakin qoidalari, Mim sakin', 'music', 7],
            [8, 'Quron oyatlarini o\'qish', 'Qisqa suralar va mashq oyatlar', 'quran', 8],
        ];
        foreach ($chapters as $c) {
            $this->insert('{{%muallimi_chapter}}', [
                'number' => $c[0], 'title_uz' => $c[1],
                'description_uz' => $c[2], 'icon' => $c[3], 'sort_order' => $c[4],
            ]);
        }

        // === DARSLAR (Bob 1) ===
        $chapterId1 = $this->db->createCommand('SELECT id FROM {{%muallimi_chapter}} WHERE number=1')->queryScalar();
        $lessons1 = [
            [1, 'Alif — أ', 'Birinchi harf Alif. U so\'z boshida unli sifatida keladi.', 'أَ إِ أُ', 'A — I — U', 'A, I, U unlilari', 1],
            [2, "Ba, Ta, Sa — ب ت ث", "Bir xil shaklda yoziladigan uch harf.", "بَ تَ ثَ", "Ba — Ta — Sa", "Ba, Ta, Sa harflari o'qilishi", 2],
            [3, 'Jim, Ha, Xa — ج ح خ', 'Bir shaklning uch ko\'rinishi.', 'جَ حَ خَ', 'Jim — Ha — Xa', 'Jim, Ha, Xa harflari', 3],
            [4, "Dal, Zal — د ذ", "Ikki bog'lanmaydigan harf.", "دَ ذَ", "Dal — Zal", "Dal va Zal farqi", 4],
            [5, 'Ra, Zay — ر ز', "Ikki bog'lanmaydigan harf.", 'رَ زَ', 'Ra — Zay', 'Ra va Zay', 5],
            [6, 'Sin, Shin — س ش', "Tishsimon harflar.", "سَ شَ", "Sin — Shin", "Sin va Shin", 6],
            [7, 'Sod, Zod — ص ض', 'Qalin harflar.', 'صَ ضَ', 'Sod — Zod', 'Qalin harflar', 7],
            [8, "To', Zo' — ط ظ", "Qalin harflar.", "طَ ظَ", "To' — Zo'", "Qalin harflar (2)", 8],
            [9, "Ayn, G'ayn — ع غ", "Tomoq harflari.", "عَ غَ", "Ayn — G'ayn", "Tomoq harflari", 9],
            [10, "Fa, Qof — ف ق", "Labial va tomoq harflari.", "فَ قَ", "Fa — Qof", "Fa va Qof", 10],
            [11, 'Kof, Lam — ك ل', 'Keng tarqalgan harflar.', 'كَ لَ', 'Kof — Lam', 'Kof va Lam', 11],
            [12, 'Mim, Nun — م ن', 'Burun undoshlari.', 'مَ نَ', 'Mim — Nun', 'Mim va Nun', 12],
            [13, 'Ha, Vav, Ya — ه و ي', 'Oxirgi uch harf.', 'هَ وَ يَ', 'Ha — Vav — Ya', 'So\'nggi harflar', 13],
        ];
        foreach ($lessons1 as $l) {
            $this->insert('{{%muallimi_lesson}}', [
                'chapter_id' => $chapterId1, 'number' => $l[0], 'title_uz' => $l[1],
                'content_uz' => $l[2], 'arabic_text' => $l[3],
                'transliteration' => $l[4], 'translation_uz' => $l[5],
                'xp_reward' => 20, 'sort_order' => $l[6],
            ]);
        }

        // === DARSLAR (Bob 2: Harakatlar) ===
        $chapterId2 = $this->db->createCommand('SELECT id FROM {{%muallimi_chapter}} WHERE number=2')->queryScalar();
        $lessons2 = [
            [1, 'Fatha — َ (a ovozi)', 'Harfning ustida. Qisqa "a" ovozini beradi.', 'بَ تَ جَ دَ', 'ba ta ja da', 'ba, ta, ja, da', 1],
            [2, 'Kasra — ِ (i ovozi)', 'Harfning ostida. Qisqa "i" ovozini beradi.', 'بِ تِ جِ دِ', 'bi ti ji di', 'bi, ti, ji, di', 2],
            [3, 'Damma — ُ (u ovozi)', 'Harfning ustida (halqa). Qisqa "u" ovozini beradi.', 'بُ تُ جُ دُ', 'bu tu ju du', 'bu, tu, ju, du', 3],
            [4, "Uch harakatni birgalikda o'qish", 'Bir harfning uch ko\'rinishi: fatha, kasra, damma.', 'بَ بِ بُ — تَ تِ تُ — جَ جِ جُ', 'ba bi bu — ta ti tu — ja ji ju', 'Barcha harakat kombinatsiyalari', 4],
            [5, "So'zlarda harakatlar", 'Harakatli so\'zlarni o\'qish mashqi.', 'كَتَبَ — قَرَأَ — ذَهَبَ', 'kataba — qara\'a — zahaba', 'yozdi — o\'qidi — ketdi', 5],
        ];
        foreach ($lessons2 as $l) {
            $this->insert('{{%muallimi_lesson}}', [
                'chapter_id' => $chapterId2, 'number' => $l[0], 'title_uz' => $l[1],
                'content_uz' => $l[2], 'arabic_text' => $l[3],
                'transliteration' => $l[4], 'translation_uz' => $l[5],
                'xp_reward' => 20, 'sort_order' => $l[6],
            ]);
        }

        // === DARSLAR (Bob 3: Tanvin) ===
        $chapterId3 = $this->db->createCommand('SELECT id FROM {{%muallimi_chapter}} WHERE number=3')->queryScalar();
        $lessons3 = [
            [1, 'Tanvini fath — ً (-an)', 'So\'z oxirida ikki fatha. "-an" deb o\'qiladi.', 'كِتَابًا — رَجُلًا', 'kitāban — rajulan', 'kitobni — erkakni', 1],
            [2, 'Tanvini kasr — ٍ (-in)', 'So\'z oxirida ikki kasra. "-in" deb o\'qiladi.', 'بَيْتٍ — كِتَابٍ', 'baytin — kitābin', 'uyda — kitobda', 2],
            [3, 'Tanvini damm — ٌ (-un)', 'So\'z oxirida ikki damma. "-un" deb o\'qiladi.', 'رَجُلٌ — بَيْتٌ', 'rajulun — baytun', 'bir erkak — bir uy', 3],
            [4, 'Tanvin bilan jumlalar', 'Tanvinli so\'zlarni jumlada ishlatish.', 'هَذَا كِتَابٌ — هَذَا بَيْتٌ', 'hāzā kitābun — hāzā baytun', 'Bu kitob — Bu uy', 4],
        ];
        foreach ($lessons3 as $l) {
            $this->insert('{{%muallimi_lesson}}', [
                'chapter_id' => $chapterId3, 'number' => $l[0], 'title_uz' => $l[1],
                'content_uz' => $l[2], 'arabic_text' => $l[3],
                'transliteration' => $l[4], 'translation_uz' => $l[5],
                'xp_reward' => 20, 'sort_order' => $l[6],
            ]);
        }

        // === DARSLAR (Bob 4: Sukun va Shaddah) ===
        $chapterId4 = $this->db->createCommand('SELECT id FROM {{%muallimi_chapter}} WHERE number=4')->queryScalar();
        $lessons4 = [
            [1, 'Sukun — ْ (sokin harf)', 'Harfning ustidagi halqa. Unli ovoz yo\'q.', 'مَكْتَبٌ — مَسْجِدٌ', 'maktabun — masjidun', 'maktab — masjid', 1],
            [2, 'Shaddah — ّ (qo\'shilgan harf)', 'Harf ikki marta aytiladi.', 'مُحَمَّدٌ — رَبٌّ', 'muḥammadun — rabbun', 'Muhammad — Rabb', 2],
            [3, 'Sukun va shaddah bilan so\'zlar', 'Amaliy mashq.', 'عِلْمٌ — صَلَاةٌ — إِسْلَامٌ', 'ʿilmun — ṣalātun — islāmun', 'ilm — namoz — islom', 3],
        ];
        foreach ($lessons4 as $l) {
            $this->insert('{{%muallimi_lesson}}', [
                'chapter_id' => $chapterId4, 'number' => $l[0], 'title_uz' => $l[1],
                'content_uz' => $l[2], 'arabic_text' => $l[3],
                'transliteration' => $l[4], 'translation_uz' => $l[5],
                'xp_reward' => 20, 'sort_order' => $l[6],
            ]);
        }

        // === DARSLAR (Bob 5: Madd) ===
        $chapterId5 = $this->db->createCommand('SELECT id FROM {{%muallimi_chapter}} WHERE number=5')->queryScalar();
        $lessons5 = [
            [1, 'Alif Madd — ā (uzun a)', 'Fathadan keyin alif. 2 harakat cho\'ziladi.', 'كِتَاب — بَاب — قَالَ', 'kitāb — bāb — qāla', 'kitob — eshik — dedi', 1],
            [2, 'Vav Madd — ū (uzun u)', 'Dammadan keyin vav. 2 harakat cho\'ziladi.', 'نُور — سُورَة — دُود', 'nūr — sūra — dūd', 'nur — sura — qurt', 2],
            [3, 'Ya Madd — ī (uzun i)', 'Kasradan keyin ya. 2 harakat cho\'ziladi.', 'كَبِير — صَغِير — جَمِيل', 'kabīr — ṣaġīr — jamīl', 'katta — kichik — chiroyli', 3],
            [4, 'Madd bilan mashq', "Uch turdagi madd bo'lgan so'zlarni o'qish.", 'الرَّحِيمِ — الرَّحْمَٰنِ — الْعَالَمِينَ', 'ar-raḥīmi — ar-raḥmāni — al-ʿālamīna', 'Rahimli — Rahmli — Olamlar', 4],
        ];
        foreach ($lessons5 as $l) {
            $this->insert('{{%muallimi_lesson}}', [
                'chapter_id' => $chapterId5, 'number' => $l[0], 'title_uz' => $l[1],
                'content_uz' => $l[2], 'arabic_text' => $l[3],
                'transliteration' => $l[4], 'translation_uz' => $l[5],
                'xp_reward' => 25, 'sort_order' => $l[6],
            ]);
        }

        // === DARSLAR (Bob 8: Qisqa suralar) ===
        $chapterId8 = $this->db->createCommand('SELECT id FROM {{%muallimi_chapter}} WHERE number=8')->queryScalar();
        $lessons8 = [
            [1, 'Sura Al-Fotiha', 'Qur\'onning birinchi surasi — 7 oyat.', 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ ﴿١﴾ الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ ﴿٢﴾', 'Bismillāhir-raḥmānir-raḥīm. Al-ḥamdu lillāhi rabbil-ʿālamīn.', 'Mehribon va Rahimli Alloh nomi bilan. Barcha hamdu sanolar olamlar Rabbiga xosdir.', 1],
            [2, 'Sura Al-Ikhlos', 'Qur\'onning 112-surasi.', 'قُلْ هُوَ اللَّهُ أَحَدٌ ﴿١﴾ اللَّهُ الصَّمَدُ ﴿٢﴾ لَمْ يَلِدْ وَلَمْ يُولَدْ ﴿٣﴾ وَلَمْ يَكُن لَّهُۥ كُفُوًا أَحَدٌ ﴿٤﴾', 'Qul huwa Allāhu aḥad. Allāhuṣ-ṣamad. Lam yalid wa lam yūlad. Wa lam yakul lahū kufuwan aḥad.', 'Ayting: U — Alloh birdir. Alloh — muhtoj emas. U tug\'ilmagan va tug\'ilmagan. Unga teng hech kim yo\'qdir.', 2],
            [3, 'Sura Al-Falaq', 'Qur\'onning 113-surasi.', 'قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ', 'Qul aʿūzhu birabbil-falaq', 'Ayting: Tongning Rabbidan panoh so\'rayman', 3],
            [4, 'Sura An-Nas', 'Qur\'onning 114-surasi.', 'قُلْ أَعُوذُ بِرَبِّ النَّاسِ', 'Qul aʿūzhu birabbinnās', 'Ayting: Odamlarning Rabbidan panoh so\'rayman', 4],
        ];
        foreach ($lessons8 as $l) {
            $this->insert('{{%muallimi_lesson}}', [
                'chapter_id' => $chapterId8, 'number' => $l[0], 'title_uz' => $l[1],
                'content_uz' => $l[2], 'arabic_text' => $l[3],
                'transliteration' => $l[4], 'translation_uz' => $l[5],
                'xp_reward' => 30, 'sort_order' => $l[6],
            ]);
        }
    }

    public function down()
    {
        $this->delete('{{%muallimi_lesson}}');
        $this->delete('{{%muallimi_chapter}}');
    }
}
