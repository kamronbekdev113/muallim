<?php
use yii\db\Migration;

class m260316_100009_seed_arabic_letters extends Migration
{
    public function up()
    {
        $letters = [
            ['أ','Alif','a','أ','ا','ـا','ـا','Ochiq unli tovush','[{"word":"أَب","meaning":"ota"},{"word":"أَسَد","meaning":"sher"}]',1],
            ['ب','Ba','b','ب','بـ','ـبـ','ـب','Labial undosh','[{"word":"بَيْت","meaning":"uy"},{"word":"بَحْر","meaning":"dengiz"}]',2],
            ['ت','Ta','t','ت','تـ','ـتـ','ـت','Tish undoshi','[{"word":"تُفَّاحَة","meaning":"olma"},{"word":"تَمْر","meaning":"xurmo"}]',3],
            ['ث','Sa','s̱','ث','ثـ','ـثـ','ـث','Ingliz th (think) singari','[{"word":"ثَعْلَب","meaning":"tulki"},{"word":"ثَوْب","meaning":"kiyim"}]',4],
            ['ج','Jim','j','ج','جـ','ـجـ','ـج','O\'zbek j tovushi','[{"word":"جَبَل","meaning":"tog\'"},{"word":"جَمَل","meaning":"tuya"}]',5],
            ['ح','Ha','ḥ','ح','حـ','ـحـ','ـح','Chuqur tomoq h tovushi','[{"word":"حَمَامَة","meaning":"kabutar"},{"word":"حَلِيب","meaning":"sut"}]',6],
            ['خ','Xa','x','خ','خـ','ـخـ','ـخ','O\'zbek x (xona) singari','[{"word":"خُبْز","meaning":"non"},{"word":"خَيْر","meaning":"yaxshilik"}]',7],
            ['د','Dal','d','د','د','ـد','ـد','Tish d tovushi','[{"word":"دَرْس","meaning":"dars"},{"word":"دُبّ","meaning":"ayiq"}]',8],
            ['ذ','Zal','ẕ','ذ','ذ','ـذ','ـذ','Ingliz th (this) singari','[{"word":"ذَهَب","meaning":"oltin"},{"word":"ذِئْب","meaning":"bo\'ri"}]',9],
            ['ر','Ra','r','ر','ر','ـر','ـر','Til uchi r tovushi','[{"word":"رَجُل","meaning":"erkak"},{"word":"رَمَضَان","meaning":"Ramazon"}]',10],
            ['ز','Zay','z','ز','ز','ـز','ـز','O\'zbek z tovushi','[{"word":"زَيْتُون","meaning":"zaytun"},{"word":"زَهْرَة","meaning":"gul"}]',11],
            ['س','Sin','s','س','سـ','ـسـ','ـس','O\'zbek s tovushi','[{"word":"سَمَك","meaning":"baliq"},{"word":"سَمَاء","meaning":"osmon"}]',12],
            ['ش','Shin','sh','ش','شـ','ـشـ','ـش','O\'zbek sh tovushi','[{"word":"شَجَرَة","meaning":"daraxt"},{"word":"شَمْس","meaning":"quyosh"}]',13],
            ['ص','Sod','ṣ','ص','صـ','ـصـ','ـص','Qalin s tovushi','[{"word":"صَبْر","meaning":"sabr"},{"word":"صَلَاة","meaning":"namoz"}]',14],
            ['ض','Zod','ḍ','ض','ضـ','ـضـ','ـض','Qalin z tovushi','[{"word":"ضَوْء","meaning":"nur"},{"word":"ضَيْف","meaning":"mehmon"}]',15],
            ['ط','To','ṭ','ط','طـ','ـطـ','ـط','Qalin t tovushi','[{"word":"طَالِب","meaning":"talaba"},{"word":"طَيِّب","meaning":"yaxshi"}]',16],
            ['ظ','Zo','ẓ','ظ','ظـ','ـظـ','ـظ','Qalin z/th tovushi','[{"word":"ظَلَام","meaning":"zulmat"},{"word":"ظَبِي","meaning":"kiyik"}]',17],
            ['ع','Ayn','ʿ','ع','عـ','ـعـ','ـع','Tomoq ع tovushi','[{"word":"عَيْن","meaning":"ko\'z/buloq"},{"word":"عِلْم","meaning":"ilm"}]',18],
            ['غ','Gayn','ġ','غ','غـ','ـغـ','ـغ','G\' fransuz r singari','[{"word":"غُرْفَة","meaning":"xona"},{"word":"غَنَم","meaning":"qo\'y"}]',19],
            ['ف','Fa','f','ف','فـ','ـفـ','ـف','Labio-dental f','[{"word":"فَرَس","meaning":"ot"},{"word":"فُلُوس","meaning":"pul"}]',20],
            ['ق','Qof','q','ق','قـ','ـقـ','ـق','Chuqur Q tovushi','[{"word":"قَلَم","meaning":"qalam"},{"word":"قُرْآن","meaning":"Qur\'on"}]',21],
            ['ك','Kof','k','ك','كـ','ـكـ','ـك','O\'zbek k tovushi','[{"word":"كِتَاب","meaning":"kitob"},{"word":"كَلْب","meaning":"it"}]',22],
            ['ل','Lam','l','ل','لـ','ـلـ','ـل','O\'zbek l tovushi','[{"word":"لَيْل","meaning":"tun"},{"word":"لَبَن","meaning":"sut"}]',23],
            ['م','Mim','m','م','مـ','ـمـ','ـم','O\'zbek m tovushi','[{"word":"مَاء","meaning":"suv"},{"word":"مَسْجِد","meaning":"masjid"}]',24],
            ['ن','Nun','n','ن','نـ','ـنـ','ـن','O\'zbek n tovushi','[{"word":"نُور","meaning":"nur"},{"word":"نَهْر","meaning":"daryo"}]',25],
            ['ه','Ha','h','ه','هـ','ـهـ','ـه','Yumshoq h tovushi','[{"word":"هِلَال","meaning":"hilol"},{"word":"هَوَاء","meaning":"havo"}]',26],
            ['و','Vav','v/w','و','و','ـو','ـو','Unli va undosh','[{"word":"وَرْد","meaning":"atirgul"},{"word":"وَلَد","meaning":"bola"}]',27],
            ['ي','Ya','y','ي','يـ','ـيـ','ـي','Unli va undosh','[{"word":"يَد","meaning":"qo\'l"},{"word":"يَوْم","meaning":"kun"}]',28],
        ];

        foreach ($letters as $l) {
            $this->insert('{{%arabic_letter}}', [
                'letter'          => $l[0],
                'name_uz'         => $l[1],
                'transliteration' => $l[2],
                'isolated'        => $l[3],
                'initial'         => $l[4],
                'medial'          => $l[5],
                'final'           => $l[6],
                'pronunciation_note' => $l[7],
                'examples_json'   => $l[8],
                'sort_order'      => $l[9],
            ]);
        }
    }

    public function down()
    {
        $this->delete('{{%arabic_letter}}');
    }
}
