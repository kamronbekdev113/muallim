<?php
use yii\db\Migration;

/**
 * Muallimi Soniy guided o'quv rejasi (boblar + darslar), Shayx Alijon qori
 * YouTube darslari (video_id) bilan. Harflar bobi alohida (/alifbo) — bu yerda
 * harakat/madd, shaddah/tanvin, hamza/maxsus, tajvid qoidalari va suralar.
 */
class m260618_120002_reseed_muallimi_curriculum extends Migration
{
    public function safeUp()
    {
        $cols = \Yii::$app->db->getTableSchema('{{%muallimi_lesson}}', true)->columnNames;
        if (!in_array('video_id', $cols)) {
            $this->addColumn('{{%muallimi_lesson}}', 'video_id', $this->string(20)->defaultValue(''));
        }
        if (!in_array('book_page', $cols)) {
            $this->addColumn('{{%muallimi_lesson}}', 'book_page', $this->smallInteger()->defaultValue(0));
        }

        // Eski darslar/boblarni tozalash (FK tartibida)
        $this->delete('{{%muallimi_lesson}}');
        $this->delete('{{%muallimi_chapter}}');

        $chapters = [
            [1, 'Harakat va Madd', 'Qisqa unlilar (fatha/kasra/damma) va cho\'ziq unlilar', 'star'],
            [2, 'Shaddah va Tanvin', 'Qo\'sh harf (tashdid) va so\'z oxiri tanvin (-an/-in/-un)', 'layer-group'],
            [3, 'Hamza va maxsus harflar', 'Hamza, ta marbuta, cho\'ziq (muqaddar) aliflar', 'asterisk'],
            [4, 'Tajvid qoidalari', 'Shamsiyya/qamariyya, vaqf, idg\'om, iqlob, Alloh lafzi', 'music'],
            [5, 'Suralar', 'Fotiha va qisqa suralar — Alijon qori bilan', 'quran'],
        ];
        foreach ($chapters as $c) {
            $this->insert('{{%muallimi_chapter}}', [
                'number' => $c[0], 'title_uz' => $c[1], 'description_uz' => $c[2],
                'icon' => $c[3], 'sort_order' => $c[0], 'active' => 1,
            ]);
        }

        // [number, title, content_uz, video_id, book_page, xp]
        $lessons = [
            1 => [
                [1, 'Harakatlar — fatha, kasra, damma', "Harf ustidagi yoki ostidagi belgilar ovozni belgilaydi: fatha (ﹷ) — «a», kasra (ﹻ) — «i», damma (ﹹ) — «u». Masalan: بَ = ba, بِ = bi, بُ = bu.", 'DhbimE6IrSE', 1, 20],
                [2, 'Madd — cho\'ziq unlilar', "Alif (ا), vov (و) va yo (ي) cho'zib o'qiladi (2 harakat ≈ 1 soniya). Masalan: قَالَ = qoola, نُور = nuur, كَبِير = kabiir.", '1i1LRB6ixr4', 13, 25],
            ],
            2 => [
                [1, 'Shaddah (tashdid) — qo\'sh harf', "Harf ustidagi (ﹼ) belgisi harf IKKI marta aytilishini bildiradi. Masalan: رَبّ = rabb, اِنّ = inn, مُحَمَّد = Muhammad.", 'PXcdBw2Ycx4', 16, 20],
                [2, 'Tanvin va tanvinli tashdid', "So'z oxirida ikki harakat — sokin «n» qo'shilgandek o'qiladi: «-an» (ً), «-in» (ٍ), «-un» (ٌ). Masalan: كِتَابًا = kitaaban, بَيْتٍ = baytin, رَجُلٌ = rajulun.", '3Xqv9Lo0h88', 19, 20],
            ],
            3 => [
                [1, 'Hamza (ء)', "Bo'g'izdan keskin uziladigan tovush. Alif, vov yoki yo ustida/ostida kelishi mumkin: أَ إِ أُ ؤ ئ.", 'gP4bbsDG1C8', 21, 20],
                [2, 'Ta marbuta (ة)', "So'z oxiridagi «yumaloq t». Vaqf (to'xtash)da «h», davom etganda «t» o'qiladi.", '39lT-YwueM4', 0, 20],
                [3, 'Muqaddar (yashirin) alif', "Yozilmaydi, lekin cho'zib o'qiladi — xanjar alif (ٰ). Masalan: هَٰذَا = haazaa, اللّٰه = Alloh.", '2XYApww_2Rc', 23, 20],
                [4, 'Muqaddar vov va ya', "Kasra/damma uzun aytilgan joylarda yo/vov yashirin cho'ziladi: بِهِ = bihii, لَهُ = lahuu.", '9PaZg6TDoxY', 23, 20],
                [5, 'Cho\'ziq (madlik) aliflar', "So'z ichidagi cho'ziq harflarni to'g'ri cho'zish mashqi.", 'MNa1l40wV8E', 0, 20],
                [6, 'Yozuvda o\'qilmaydigan harflar', "Ba'zi yozilgan harflar o'qilmaydi (masalan ba'zi aliflar).", 'iATPBMSWfe4', 0, 20],
            ],
            4 => [
                [1, 'Qamariyya harflari va vasliya hamzasi', "«Oy harflari» oldidan «ال» ning lomi ANIQ o'qiladi: الْقَمَر = al-qamar.", '53UiqNRUuHs', 25, 25],
                [2, 'Shamsiyya harflari (lom o\'qilmaydi)', "«Quyosh harflari» oldidan «ال» ning lomi O'QILMAYDI, keyingi harf qo'shaloq bo'ladi: الشَّمْس = ash-shams.", '15M6Z7zcEXI', 25, 25],
                [3, 'Qamariyya, shamsiyya va vasliya (takror)', "Ikkala qoidani birga mashq qilish.", 'Vlms7i490M0', 0, 20],
                [4, 'Kalimalar so\'ngida to\'xtash (vaqf)', "So'z/oyat oxirida qanday to'xtash kerakligi.", 'sDfqDF8hOxA', 27, 20],
                [5, 'Madlik kalimalarga to\'xtash', "Oxiri cho'ziq so'zlarda to'xtash qoidasi.", 'YQrroHDxPKc', 0, 20],
                [6, 'Idg\'om qoidasi', "Nun sokin/tanvin keyingi harfga singdirib o'qiladi (ينمو harflari).", 'ZGvFRcB5g1M', 0, 25],
                [7, 'Iqlob qoidasi', "Nun sokin/tanvin + «ب» — «m» ga aylanadi.", 'xLK-lvetVlg', 0, 25],
                [8, 'Alloh lafzi o\'qilishi', "«اللّٰه» so'zi oldidagi harakatga qarab yo'g'on yoki ingichka o'qiladi.", 'HDtdqQkJNn8', 0, 25],
                [9, 'Iymon kalimalari', "Kalima shahodat va muhim iboralarni to'g'ri o'qish.", 'Ly3nseFkOqo', 0, 30],
            ],
            5 => [
                [1, 'Fotiha surasi', "Qur'onning birinchi surasi — 7 oyat.", '9w7E9COL-ck', 0, 30,
                    'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ ۝ الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ ۝ الرَّحْمَٰنِ الرَّحِيمِ ۝ مَالِكِ يَوْمِ الدِّينِ ۝ إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ ۝ اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ ۝ صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
                    "Mehribon va Rahmli Alloh nomi bilan. Hamd olamlar Rabbi Allohga xosdir..."],
                [2, 'Baqara surasi (1-5 oyat)', "Baqara surasining boshlanishi.", 'uwOvz2AqIdA', 0, 30],
                [3, 'Shams surasi', "91-sura.", 'vBCB6el2vPU', 0, 25],
                [4, 'Layl surasi', "92-sura.", 'STf87ZkdM9A', 0, 25],
                [5, 'Sharh surasi', "94-sura.", 'uVtRXANmflY', 0, 25],
                [6, 'Tiyn surasi', "95-sura.", '3N19nL1nwp4', 0, 25],
                [7, 'Alaq surasi', "96-sura.", 'b7W67MmN6DI', 0, 25],
                [8, 'Qadr surasi', "97-sura.", 'BLu2hq4mits', 0, 25],
                [9, 'Bayyina surasi', "98-sura.", 'B2l63G1Hj04', 0, 25],
                [10, 'Zalzala surasi', "99-sura.", 'M4dT61QDqRA', 0, 25],
                [11, 'Adiyat surasi', "100-sura.", 'GMCr8UJfhs4', 0, 25],
                [12, 'Qoria surasi', "101-sura.", '5Dsjw1NJj8A', 0, 25],
                [13, 'Takasur surasi', "102-sura.", 'zW4-1hzoYuk', 0, 25],
                [14, 'Asr surasi', "103-sura.", 'cueFhFyY9jg', 0, 25],
                [15, 'Humaza surasi', "104-sura.", 'BlRlQd-bD3c', 0, 25],
                [16, 'Fil surasi', "105-sura.", 'W6qqV4LwEa0', 0, 25],
                [17, 'Quraysh surasi', "106-sura.", 'Ab2Tf9Hta-U', 0, 25],
                [18, 'Maun surasi', "107-sura.", 'wOWoP9GFw8g', 0, 25],
                [19, 'Kavsar surasi', "108-sura.", '2_26ubDV-vo', 0, 25],
                [20, 'Kafirun surasi', "109-sura.", '0xfUFdTN-oA', 0, 25],
                [21, 'Nasr surasi', "110-sura.", 'lP3c9nDVObA', 0, 25],
                [22, 'Masad (Lahab) surasi', "111-sura.", 'Amw4yhQN3k0', 0, 25],
                [23, 'Ixlos surasi', "112-sura — 4 oyat.", 'qf95Xp_hWYg', 0, 30,
                    'قُلْ هُوَ اللَّهُ أَحَدٌ ۝ اللَّهُ الصَّمَدُ ۝ لَمْ يَلِدْ وَلَمْ يُولَدْ ۝ وَلَمْ يَكُن لَّهُ كُفُوًا أَحَدٌ',
                    "Ayting: U — Alloh birdir. Alloh — beniyoz. Tug'magan va tug'ilmagan. Unga teng hech kim yo'q."],
                [24, 'Falaq surasi', "113-sura.", 'd5sHlSWa8-w', 0, 30,
                    'قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ ۝ مِن شَرِّ مَا خَلَقَ ۝ وَمِن شَرِّ غَاسِقٍ إِذَا وَقَبَ ۝ وَمِن شَرِّ النَّفَّاثَاتِ فِي الْعُقَدِ ۝ وَمِن شَرِّ حَاسِدٍ إِذَا حَسَدَ',
                    "Ayting: Tongning Rabbidan panoh so'rayman..."],
                [25, 'Nas surasi', "114-sura.", 'pOZFVYVbuGc', 0, 30,
                    'قُلْ أَعُوذُ بِرَبِّ النَّاسِ ۝ مَلِكِ النَّاسِ ۝ إِلَٰهِ النَّاسِ ۝ مِن شَرِّ الْوَسْوَاسِ الْخَنَّاسِ ۝ الَّذِي يُوَسْوِسُ فِي صُدُورِ النَّاسِ ۝ مِنَ الْجِنَّةِ وَالنَّاسِ',
                    "Ayting: Odamlarning Rabbidan panoh so'rayman..."],
            ],
        ];

        foreach ($lessons as $chNum => $rows) {
            $chId = $this->db->createCommand('SELECT id FROM {{%muallimi_chapter}} WHERE number=:n', [':n' => $chNum])->queryScalar();
            foreach ($rows as $r) {
                $this->insert('{{%muallimi_lesson}}', [
                    'chapter_id'     => $chId,
                    'number'         => $r[0],
                    'title_uz'       => $r[1],
                    'content_uz'     => $r[2],
                    'video_id'       => $r[3],
                    'book_page'      => $r[4],
                    'xp_reward'      => $r[5],
                    'arabic_text'    => $r[6] ?? null,
                    'translation_uz' => $r[7] ?? null,
                    'sort_order'     => $r[0],
                    'active'         => 1,
                ]);
            }
        }
    }

    public function safeDown()
    {
        $this->delete('{{%muallimi_lesson}}');
        $this->delete('{{%muallimi_chapter}}');
        foreach (['video_id', 'book_page'] as $c) {
            try { $this->dropColumn('{{%muallimi_lesson}}', $c); } catch (\Throwable $e) {}
        }
    }
}
