<?php
use yii\db\Migration;

class m260317_000002_seed_vocabulary extends Migration
{
    public function up()
    {
        $rows = [
            // --- Alloh sifatlari ---
            ['الله','','Alloh','Allah — Yagona Iloh','names',1],
            ['رَبّ','ر ب ب','Rabb','Parvardigor, Ega','names',1],
            ['الرَّحْمَٰن','ر ح م','Ar-Rahmān','Mehribon (barchaga)','names',1],
            ['الرَّحِيم','ر ح م','Ar-Rahīm','Rahmdil (mo\'minlarga)','names',1],
            ['الْمَلِك','م ل ك','Al-Malik','Podshoh, Hukmron','names',2],
            ['الْعَلِيم','ع ل م','Al-Alīm','Biluvchi','names',2],
            ['الْحَكِيم','ح ك م','Al-Hakīm','Donishmand, Hikmator','names',2],
            ['الْقَدِير','ق د ر','Al-Qadīr','Qodir, Kuchli','names',2],
            ['الْغَفُور','غ ف ر','Al-Ghafūr','Kechiruvchi','names',2],
            ['الْكَرِيم','ك ر م','Al-Karīm','Saxiy, Mukarram','names',2],

            // --- Eng ko'p uchragan fe'llar ---
            ['قَالَ','ق و ل','qāla','dedi, so\'zladi','verbs',1],
            ['كَانَ','ك و ن','kāna','edi, bo\'ldi','verbs',1],
            ['جَاءَ','ج ي أ','jā\'a','keldi','verbs',1],
            ['أَرْسَلَ','ر س ل','arsala','yubordi','verbs',2],
            ['آمَنَ','أ م ن','āmana','iymon keltirdi','verbs',2],
            ['عَمِلَ','ع م ل','amila','qildi, ish qildi','verbs',1],
            ['خَلَقَ','خ ل ق','khalaqa','yaratdi','verbs',2],
            ['دَخَلَ','د خ ل','dakhala','kirdi','verbs',1],
            ['خَرَجَ','خ ر ج','kharaja','chiqdi','verbs',1],
            ['نَزَلَ','ن ز ل','nazala','tushdi, nozil bo\'ldi','verbs',2],
            ['عَلِمَ','ع ل م','alima','bildi','verbs',2],
            ['أَعْطَى','ع ط و','a\'ṭā','berdi','verbs',1],
            ['رَأَى','ر أ ي','ra\'ā','ko\'rdi','verbs',1],
            ['سَمِعَ','س م ع','sami\'a','eshitdi','verbs',1],
            ['قَرَأَ','ق ر أ','qara\'a','o\'qidi','verbs',2],

            // --- Asosiy otlar ---
            ['الْحَمْد','ح م د','Al-hamd','Hamd, maqtov','nouns',1],
            ['نَبِيّ','ن ب أ','nabiyy','nabi, payg\'ambar','nouns',1],
            ['رَسُول','ر س ل','rasūl','elchi, rasul','nouns',1],
            ['كِتَاب','ك ت ب','kitāb','kitob','nouns',1],
            ['نُور','ن و ر','nūr','nur, yorug\'lik','nouns',1],
            ['يَوْم','ي و م','yawm','kun','nouns',1],
            ['آيَة','أ ي ي','āyah','oyat, belgi','nouns',1],
            ['سُورَة','س و ر','sūrah','sura','nouns',1],
            ['صَلَاة','ص ل و','ṣalāh','namoz','nouns',1],
            ['إِيمَان','أ م ن','īmān','iymon','nouns',1],
            ['جَنَّة','ج ن ن','jannah','jannat','nouns',1],
            ['نَار','ن و ر','nār','do\'zax, o\'t','nouns',2],
            ['عِلْم','ع ل م','ilm','ilm, bilim','nouns',1],
            ['قَلْب','ق ل ب','qalb','yurak, qalb','nouns',1],
            ['إِنْسَان','أ ن س','insān','inson','nouns',1],

            // --- Bo'lim, yuklama va boglovchilar ---
            ['مِن','م ن','min','dan, dan (kelish)','particles',1],
            ['فِي','ف ي','fī','da, ichida','particles',1],
            ['عَلَى','ع ل و','alā','ustida, ning ustiga','particles',1],
            ['إِلَى','أ ل و','ilā','ga, tomon','particles',1],
            ['مَع','م ع','maa','bilan, birga','particles',1],
            ['لَا','ل أ','lā','yo\'q, emas','particles',1],
            ['وَ','و','wa','va, ham','particles',1],
            ['أَوْ','أ و','aw','yoki','particles',1],
            ['إِنَّ','أ ن','inna','albatta, darhaqiqat','particles',1],
            ['قَدْ','ق د','qad','allaqachon, ba\'zan','particles',2],

            // --- Kundalik iboralar ---
            ['بِسْمِ اللَّه','','Bismillāh','Alloh nomi bilan','phrases',1],
            ['الْحَمْدُ لِلَّه','','Alhamdulillāh','Allohga hamd','phrases',1],
            ['سُبْحَانَ اللَّه','','Subhānallāh','Alloh pokdir','phrases',1],
            ['اَللَّهُ أَكْبَر','','Allāhu Akbar','Alloh ulugdir','phrases',1],
            ['إِنْ شَاءَ اللَّه','','In Shā\'allāh','Alloh xohlasa','phrases',1],
            ['مَاشَاءَ اللَّه','','Māshā\'allāh','Alloh xohlagani','phrases',1],
            ['أَعُوذُ بِاللَّه','','A\'ūdhu billāh','Allohdan panoh tilayman','phrases',1],
            ['جَزَاكَ اللَّه','','Jazākallāh','Alloh sizga yaxshilik bersin','phrases',1],
            ['آمِين','','Āmīn','Amin, qabul qilgin','phrases',1],
            ['السَّلَام عَلَيْكُم','','As-salāmu alaykum','Assalomu alaykum','phrases',1],
        ];

        foreach ($rows as $r) {
            $this->insert('{{%vocabulary}}', [
                'word_ar'        => $r[0],
                'root'           => $r[1],
                'transliteration'=> $r[2],
                'translation_uz' => $r[3],
                'category'       => $r[4],
                'difficulty'     => $r[5],
            ]);
        }
    }

    public function down()
    {
        $this->truncateTable('{{%vocabulary}}');
    }
}
