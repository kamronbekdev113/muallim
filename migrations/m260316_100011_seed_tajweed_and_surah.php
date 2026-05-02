<?php
use yii\db\Migration;

class m260316_100011_seed_tajweed_and_surah extends Migration
{
    public function up()
    {
        // === TAJVID QOIDALARI ===
        $rules = [
            ['Qalqala', 'قَلْقَلَة', 'Sukun yoki vaqfda قطبجد harflari titrab chiqadi. Ular: ق ط ب ج د', '#FFD700', 'tj-qalqala', '﹯', 'وَيَقُولُ الَّذِينَ كَفَرُوا', 'Va kofirlari aytadilar', 'qalqala', 1],
            ['Ghunna', 'غُنَّة', 'Nun va Mim shaddali bo\'lganda burun orqali aytiladi. 2 harakat.', '#90EE90', 'tj-ghunna', 'ن/م', 'إِنَّ — ثُمَّ', 'Albatta — So\'ng', 'ghunna', 2],
            ['Madd Tabi\'iy', 'مَدّ طَبِيعِي', 'Tabiiy cho\'zilish. 2 harakat. Alif, Vav, Ya maddi.', '#87CEEB', 'tj-madd', 'ـا ـو ـي', 'قَالَ — يَقُولُ — قِيلَ', 'dedi — deydi — aytildi', 'madd', 3],
            ['Madd Muttasil', 'مَدّ مُتَّصِل', 'Bir so\'zda madd harfi va hamza. 4-5 harakat.', '#4FC3F7', 'tj-madd-muttasil', 'ـاءـ', 'جَاءَ — سَاءَ', 'keldi — yomon qildi', 'madd', 4],
            ['Madd Munfasil', 'مَدّ مُنْفَصِل', 'Madd harfi so\'z oxirida, hamza keyingi so\'zda. 4-5 harakat.', '#29B6F6', 'tj-madd-munfasil', 'ـا أ', 'إِنَّا أَعْطَيْنَاكَ', 'Albatta biz senga berdik', 'madd', 5],
            ['Ikhfa', 'إِخْفَاء', 'Nun sakin yoki tanvin + 15 harf. Yashiringan burun tovushi. 2 harakat.', '#FFB347', 'tj-ikhfa', 'ن° + 15', 'مِنْ قَبْلِ — عَنْ تَرَاضٍ', 'Oldin — Rozi bo\'lib', 'ikhfa', 6],
            ['Idgham', 'إِدْغَام', 'Nun sakin + ينمو harflari — singdirib o\'qish.', '#DDA0DD', 'tj-idgham', 'ن° + ينمو', 'مَنْ يَعْمَلْ — مِنْ وَلِيٍّ', 'Kimki qilsa — Hech do\'st', 'idgham', 7],
            ['Iqlab', 'إِقْلَاب', 'Nun sakin + Ba harfi — Mim ga aylantiriladi.', '#F08080', 'tj-iqlab', 'ن° + ب', 'مِنْ بَعْدِ — أَنْبِئْهُمْ', 'Keyin — Ularni xabar qil', 'iqlab', 8],
            ['Izhar', 'إِظْهَار', 'Nun sakin + حخعغأه harflari — aniq o\'qiladi.', '#B0C4DE', 'tj-izhar', 'ن° + حخعغأه', 'مِنْ خَيْرٍ — عَنْ أَنْفُسِكُمْ', 'Yaxshilikdan — O\'zingizdan', 'izhar', 9],
            ['Lam Shamsi', 'لَام شَمْسِيَّة', 'ال oldidan quyosh harflari — Lam yutiladi.', '#FFCC80', 'tj-lam-shamsi', 'ال+☀', 'الشَّمْسُ — النُّورُ — الرَّحِيمُ', 'Quyosh — Nur — Rahimli', 'other', 10],
            ['Lam Qamari', 'لَام قَمَرِيَّة', 'ال oldidan oy harflari — Lam aniq aytiladi.', '#CE93D8', 'tj-lam-qamari', 'ال+🌙', 'الْقُرْآنُ — الْكِتَابُ — الْعَالَمُ', 'Qur\'on — Kitob — Olam', 'other', 11],
            ['Waqf (To\'xtatish)', 'وَقْف', 'So\'z yoki oyat oxirida to\'g\'ri to\'xtash usullari.', '#A5D6A7', 'tj-waqf', '∘', 'وَقْفٌ لَازِمٌ — وَقْفٌ جَائِزٌ', 'Kerakli to\'xtatish — Mumkin to\'xtatish', 'other', 12],
        ];

        foreach ($rules as $r) {
            $this->insert('{{%tajweed_rule}}', [
                'name_uz' => $r[0], 'name_ar' => $r[1], 'description_uz' => $r[2],
                'color_code' => $r[3], 'css_class' => $r[4], 'symbol' => $r[5],
                'example_ar' => $r[6], 'example_translation' => $r[7],
                'category' => $r[8], 'sort_order' => $r[9],
            ]);
        }

        // === 114 SURAH ===
        $surahs = [
            [1,'الفَاتِحَة','Al-Fotiha','The Opening',7,'makki',0],
            [2,'البَقَرَة','Al-Baqara','The Cow',286,'madani',1],
            [3,'آلِ عِمْرَان',"Oli Imron",'Family of Imran',200,'madani',1],
            [4,'النِّسَاء','An-Niso','The Women',176,'madani',1],
            [5,'المَائِدَة','Al-Moida','The Table',176,'madani',1],
            [6,'الأَنْعَام','Al-Anom','The Cattle',165,'makki',1],
            [7,'الأَعْرَاف',"Al-A'rof",'The Heights',206,'makki',1],
            [8,'الأَنفَال','Al-Anfol','The Spoils',75,'madani',1],
            [9,'التَّوبَة','At-Tavba','The Repentance',129,'madani',0],
            [10,'يُونُس','Yunus','Jonah',109,'makki',1],
            [11,'هُود','Hud','Hud',123,'makki',1],
            [12,'يُوسُف','Yusuf','Joseph',111,'makki',1],
            [13,'الرَّعد','Ar-Rad','The Thunder',43,'madani',1],
            [14,'إِبْرَاهِيم','Ibrohim','Abraham',52,'makki',1],
            [15,'الحِجْر','Al-Hijr','The Rocky Tract',99,'makki',1],
            [16,'النَّحْل','An-Nahl','The Bee',128,'makki',1],
            [17,'الإِسْرَاء',"Al-Isro'",'The Night Journey',111,'makki',1],
            [18,'الكَهف','Al-Kahf','The Cave',110,'makki',1],
            [19,'مَرْيَم','Maryam','Mary',98,'makki',1],
            [20,'طه',"To'ha",'Ta-Ha',135,'makki',1],
            [21,'الأَنبِيَاء',"Al-Anbiyo'",'The Prophets',112,'makki',1],
            [22,'الحَج','Al-Hajj','The Pilgrimage',78,'madani',1],
            [23,'المُؤمِنُون',"Al-Mo'minun",'The Believers',118,'makki',1],
            [24,'النُّور','An-Nur','The Light',64,'madani',1],
            [25,'الفُرقَان','Al-Furqon','The Criterion',77,'makki',1],
            [26,'الشُّعَرَاء',"Ash-Shu'aro'",'The Poets',227,'makki',1],
            [27,'النَّمل','An-Naml','The Ant',93,'makki',1],
            [28,'القَصَص','Al-Qasas','The Stories',88,'makki',1],
            [29,'العَنكَبوت','Al-Ankabut','The Spider',69,'makki',1],
            [30,'الرُّوم','Ar-Rum','The Romans',60,'makki',1],
            [31,'لُقمَان','Luqmon','Luqman',34,'makki',1],
            [32,'السَّجدَة','As-Sajda','The Prostration',30,'makki',1],
            [33,'الأَحزَاب','Al-Ahzob','The Combined Forces',73,'madani',1],
            [34,'سَبَأ',"Saba'",'Sheba',54,'makki',1],
            [35,'فَاطِر','Fotir','Originator',45,'makki',1],
            [36,'يس','Yasin','Ya Sin',83,'makki',1],
            [37,'الصَّافَّات','As-Soffot','Those Who Set the Ranks',182,'makki',1],
            [38,'ص','Sod','Sad',88,'makki',1],
            [39,'الزُّمَر','Az-Zumar','The Troops',75,'makki',1],
            [40,'غَافِر','G\'ofir','The Forgiver',85,'makki',1],
            [41,'فُصِّلَت','Fussilat','Explained in Detail',54,'makki',1],
            [42,'الشُّورَى','Ash-Shura','The Consultation',53,'makki',1],
            [43,'الزُّخرُف','Az-Zuxruf','The Ornaments',89,'makki',1],
            [44,'الدُّخَان','Ad-Duxon','The Smoke',59,'makki',1],
            [45,'الجَاثِيَة','Al-Josiya','The Crouching',37,'makki',1],
            [46,'الأَحقَاف','Al-Ahqof','The Wind-Curved Sandhills',35,'makki',1],
            [47,'مُحَمَّد','Muhammad','Muhammad',38,'madani',1],
            [48,'الفَتح','Al-Fath','The Victory',29,'madani',1],
            [49,'الحُجُرَات','Al-Hujurot','The Rooms',18,'madani',1],
            [50,'قٓ','Qof','Qaf',45,'makki',1],
            [51,'الذَّارِيَات','Az-Zoriyot','The Winnowing Winds',60,'makki',1],
            [52,'الطُّور','At-Tur','The Mount',49,'makki',1],
            [53,'النَّجم','An-Najm','The Star',62,'makki',1],
            [54,'القَمَر','Al-Qamar','The Moon',55,'makki',1],
            [55,'الرَّحمَٰن','Ar-Rahman','The Beneficent',78,'madani',1],
            [56,'الوَاقِعَة','Al-Voqia','The Inevitable',96,'makki',1],
            [57,'الحَدِيد','Al-Hadid','The Iron',29,'madani',1],
            [58,'المُجَادِلَة','Al-Mujodala','The Pleading Woman',22,'madani',1],
            [59,'الحَشر','Al-Hashr','The Exile',24,'madani',1],
            [60,'المُمتَحَنَة','Al-Mumtahana','She That is to be Examined',13,'madani',1],
            [61,'الصَّف','As-Saff','The Ranks',14,'madani',1],
            [62,'الجُمُعَة','Al-Jumu\'a','The Congregation',11,'madani',1],
            [63,'المُنَافِقُون','Al-Munofiqun','The Hypocrites',11,'madani',1],
            [64,'التَّغَابُن','At-Teg\'obun','The Mutual Disillusion',18,'madani',1],
            [65,'الطَّلَاق','At-Taloq','The Divorce',12,'madani',1],
            [66,'التَّحرِيم','At-Tahrim','The Prohibition',12,'madani',1],
            [67,'المُلك','Al-Mulk','The Sovereignty',30,'makki',1],
            [68,'القَلَم','Al-Qalam','The Pen',52,'makki',1],
            [69,'الحَاقَّة','Al-Hoqqa','The Reality',52,'makki',1],
            [70,'المَعَارِج','Al-Ma\'orij','The Ascending Stairways',44,'makki',1],
            [71,'نُوح','Nuh','Noah',28,'makki',1],
            [72,'الجِنّ','Al-Jinn','The Jinn',28,'makki',1],
            [73,'المُزَّمِّل','Al-Muzzammil','The Enshrouded One',20,'makki',1],
            [74,'المُدَّثِّر','Al-Muddassir','The Cloaked One',56,'makki',1],
            [75,'القِيَامَة','Al-Qiyoma','The Resurrection',40,'makki',1],
            [76,'الإِنسَان','Al-Inson','The Human',31,'madani',1],
            [77,'المُرسَلَات','Al-Mursalot','The Emissaries',50,'makki',1],
            [78,'النَّبَأ',"An-Naba'",'The Tidings',40,'makki',1],
            [79,'النَّازِعَات','An-Naziot','Those who drag forth',46,'makki',1],
            [80,'عَبَسَ',"'Abasa",'He Frowned',42,'makki',1],
            [81,'التَّكوِير','At-Takwir','The Overthrowing',29,'makki',1],
            [82,'الانفِطَار','Al-Infitor','The Cleaving',19,'makki',1],
            [83,'المُطَفِّفِين','Al-Mutoffifin','The Defrauding',36,'makki',1],
            [84,'الانشِقَاق','Al-Inshiqoq','The Splitting Open',25,'makki',1],
            [85,'البُرُوج','Al-Buruj','The Mansions of the Stars',22,'makki',1],
            [86,'الطَّارِق','At-Toriq','The Morning Star',17,'makki',1],
            [87,'الأَعلَى',"Al-A'lo",'The Most High',19,'makki',1],
            [88,'الغَاشِيَة','Al-G\'oshiya','The Overwhelming',26,'makki',1],
            [89,'الفَجر','Al-Fajr','The Dawn',30,'makki',1],
            [90,'البَلَد','Al-Balad','The City',20,'makki',1],
            [91,'الشَّمس','Ash-Shams','The Sun',15,'makki',1],
            [92,'اللَّيل','Al-Layl','The Night',21,'makki',1],
            [93,'الضُّحَى',"Ad-Duho'",'The Morning Hours',11,'makki',1],
            [94,'الشَّرح','Ash-Sharh','The Consolation',8,'makki',1],
            [95,'التِّين','At-Tin','The Fig',8,'makki',1],
            [96,'العَلَق','Al-Alaq','The Clot',19,'makki',1],
            [97,'القَدر','Al-Qadr','The Power',5,'makki',1],
            [98,'البَيِّنَة','Al-Bayyina','The Clear Proof',8,'madani',1],
            [99,'الزَّلزَلَة','Az-Zalzala','The Earthquake',8,'madani',1],
            [100,'العَادِيَات','Al-Adiyot','The Courser',11,'makki',1],
            [101,'القَارِعَة','Al-Qoria','The Calamity',11,'makki',1],
            [102,'التَّكَاثُر','At-Takosur','The Rivalry in World Increase',8,'makki',1],
            [103,'العَصر','Al-Asr','The Declining Day',3,'makki',1],
            [104,'الهُمَزَة','Al-Humaza','The Traducer',9,'makki',1],
            [105,'الفِيل','Al-Fil','The Elephant',5,'makki',1],
            [106,'قُرَيش','Quraysh','Quraysh',4,'makki',1],
            [107,'المَاعُون',"Al-Mo'un",'The Small Kindnesses',7,'makki',1],
            [108,'الكَوثَر','Al-Kavsar','The Abundance',3,'makki',1],
            [109,'الكَافِرُون','Al-Kofurun','The Disbelievers',6,'makki',1],
            [110,'النَّصر','An-Nasr','The Divine Support',3,'madani',1],
            [111,'المَسَد','Al-Masad','The Palm Fibre',5,'makki',1],
            [112,'الإِخلَاص','Al-Ikhlos','The Sincerity',4,'makki',1],
            [113,'الفَلَق','Al-Falaq','The Daybreak',5,'makki',1],
            [114,'النَّاس','An-Nos','Mankind',6,'makki',1],
        ];
        foreach ($surahs as $s) {
            $this->insert('{{%surah}}', [
                'number' => $s[0], 'name_ar' => $s[1], 'name_uz' => $s[2],
                'name_en' => $s[3], 'ayah_count' => $s[4],
                'revelation_type' => $s[5], 'bismillah_pre' => $s[6],
            ]);
        }

        // === AL-FOTIHA OYATLARI (Tajvidli) ===
        $fatihaId = $this->db->createCommand('SELECT id FROM {{%surah}} WHERE number=1')->queryScalar();
        $fatihaAyahs = [
            [1, 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ',
             'Bis<span class="tj-madd">mi</span>ll<span class="tj-lam-shamsi">ā</span>hi r-raḥ<span class="tj-madd">mā</span>ni r-raḥ<span class="tj-madd">ī</span>m',
             'Mehribon va Rahimli Alloh nomi bilan', 1, 1],
            [2, 'الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ',
             'Al-ḥamdu lill<span class="tj-lam-shamsi">ā</span>hi rabbi l-<span class="tj-madd">ʿā</span>lam<span class="tj-madd">ī</span>n',
             'Barcha hamdu sanolar olamlar Rabbiga xosdir', 1, 2],
            [3, 'الرَّحْمَٰنِ الرَّحِيمِ',
             'Ar-raḥ<span class="tj-madd">mā</span>ni r-raḥ<span class="tj-madd">ī</span>m',
             'Mehribon, Rahimli', 1, 3],
            [4, 'مَالِكِ يَوْمِ الدِّينِ',
             '<span class="tj-madd">Mā</span>liki yawmi d-d<span class="tj-madd">ī</span>n',
             'Hisob kunining Egasi', 1, 4],
            [5, 'إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ',
             '<span class="tj-madd">Iyyā</span>ka naʿbudu wa-<span class="tj-madd">iyyā</span>ka nastaʿ<span class="tj-madd">ī</span>n',
             'Faqat Senga ibodat qilamiz va faqat Sendan yordam so\'raymiz', 1, 5],
            [6, 'اهْدِنَا الصِّرَاطَ الْمُسْتَقِيمَ',
             'Ihdin<span class="tj-ghunna">ā</span> ṣ-ṣir<span class="tj-madd">ā</span>ṭa l-mustaq<span class="tj-madd">ī</span>m',
             'Bizni to\'g\'ri yo\'lga hidoyat qil', 1, 6],
            [7, 'صِرَاطَ الَّذِينَ أَنْعَمْتَ عَلَيْهِمْ غَيْرِ الْمَغْضُوبِ عَلَيْهِمْ وَلَا الضَّالِّينَ',
             'Ṣir<span class="tj-madd">ā</span>ṭa l-laz<span class="tj-madd">ī</span>na anʿamta ʿalayhim ġayri l-maġḍ<span class="tj-madd">ū</span>bi ʿalayhim wa l<span class="tj-madd">ā</span> ḍ-ḍ<span class="tj-ghunna">āll</span><span class="tj-madd">ī</span>n',
             'Nimat berganlaringning yo\'li; g\'azabga uchraganlar va adashganlarning emas', 1, 7],
        ];
        foreach ($fatihaAyahs as $a) {
            $this->insert('{{%ayah}}', [
                'surah_id' => $fatihaId, 'number' => $a[0],
                'text_uthmani' => $a[1], 'text_tajweed' => $a[2],
                'translation_uz' => $a[3], 'juz' => $a[4], 'page' => $a[5],
            ]);
        }

        // === AL-IKHLOS OYATLARI ===
        $ikhlosId = $this->db->createCommand('SELECT id FROM {{%surah}} WHERE number=112')->queryScalar();
        $ikhlosAyahs = [
            [1, 'قُلْ هُوَ اللَّهُ أَحَدٌ', 'Qul huwa ll<span class="tj-lam-shamsi">ā</span>hu <span class="tj-ghunna">aḥad</span>', 'Ayting: U — Alloh birdir', 30, 604],
            [2, 'اللَّهُ الصَّمَدُ', 'All<span class="tj-lam-shamsi">ā</span>hu ṣ-ṣamad', 'Alloh — hamma muhtoj, U muhtoj emas', 30, 604],
            [3, 'لَمْ يَلِدْ وَلَمْ يُولَدْ', 'Lam yalid wa-lam <span class="tj-ikhfa">yūlad</span>', 'U tug\'ilmagan va U tug\'ilmagan', 30, 604],
            [4, 'وَلَمْ يَكُن لَّهُۥ كُفُوًا أَحَدٌ', 'Wa-lam yakul lahū kufuwa<span class="tj-ghunna">n aḥad</span>', 'Va Unga teng hech kim yo\'qdir', 30, 604],
        ];
        foreach ($ikhlosAyahs as $a) {
            $this->insert('{{%ayah}}', [
                'surah_id' => $ikhlosId, 'number' => $a[0],
                'text_uthmani' => $a[1], 'text_tajweed' => $a[2],
                'translation_uz' => $a[3], 'juz' => $a[4], 'page' => $a[5],
            ]);
        }

        // === DEFAULT USERS ===
        $now = time();
        $this->insert('{{%user}}', [
            'username' => 'admin', 'password_hash' => \Yii::$app->security->generatePasswordHash('admin123'),
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'access_token' => \Yii::$app->security->generateRandomString(40),
            'full_name' => 'Administrator', 'email' => 'admin@muallim.uz',
            'role' => 'admin', 'xp' => 0, 'streak' => 0, 'active' => 1,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $this->insert('{{%user}}', [
            'username' => 'student', 'password_hash' => \Yii::$app->security->generatePasswordHash('student123'),
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'access_token' => \Yii::$app->security->generateRandomString(40),
            'full_name' => 'Talaba', 'email' => 'student@muallim.uz',
            'role' => 'student', 'xp' => 0, 'streak' => 0, 'active' => 1,
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }

    public function down()
    {
        $this->delete('{{%ayah}}');
        $this->delete('{{%surah}}');
        $this->delete('{{%tajweed_rule}}');
        $this->delete('{{%user}}');
    }
}
