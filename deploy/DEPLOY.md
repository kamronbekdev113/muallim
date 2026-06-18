# Muallim — InfinityFree'ga tekin deploy qilish qo'llanmasi

Bu ilova: **Yii2 (PHP) + MySQL**. InfinityFree tekin PHP+MySQL+SSL beradi.
Natija: `https://sizning-subdomeningiz.infinityfreeapp.com` — telefonda ham ochiladi,
HTTPS bo'lgani uchun **mikrofon ham ishlaydi**.

> ⚠️ Repo PRIVATE bo'lsin (kitob skanlari, audio — mualliflik huquqi).

---

## 1. InfinityFree akkaunt va hosting
1. https://infinityfree.net → **Sign Up** (bepul, karta shart emas).
2. Kirgach **Create Account** → tekin subdomen tanlang (mas. `muallim.infinityfreeapp.com`)
   yoki o'z domeningizni ulang. Hosting yaratilishini kuting (~2-5 daqiqa).
3. Control panel'da **PHP version** ni **8.1 yoki 8.2** ga qo'ying (PHP Config / Settings).

## 2. MySQL baza yaratish
1. Control panel → **MySQL Databases**.
2. Yangi baza yarating (mas. nomi `muallim`). U sizga quyidagilarni beradi:
   - **DB host** (mas. `sqlXXX.infinityfree.com`)
   - **DB name** (mas. `if0_XXXXXXX_muallim`)
   - **DB user** (mas. `if0_XXXXXXX`)
   - **DB password** (siz o'rnatgan)
   Bularni saqlab qo'ying.

## 3. Bazani import qilish
1. Control panel → **phpMyAdmin** (yangi bazangizni tanlang).
2. **Import** → `deploy/muallim.sql` faylini tanlang → **Go**.
   (14 ta jadval + barcha kontent yuklanadi.)

## 4. db.php ni sozlash
`deploy/db.prod.php` ni oching, InfinityFree bergan host/db/user/parol bilan to'ldiring,
keyin uni `config/db.php` o'rniga ishlatasiz (5-bosqichda `app/config/db.php` bo'ladi).

Shuningdek `config/web.php` dagi `cookieValidationKey` ni boshqa tasodifiy matnga
o'zgartiring (xavfsizlik uchun), mas. `'cookieValidationKey' => 'BIROR-TASODIFIY-UZUN-MATN-2026'`.

## 5. Fayllarni FTP bilan yuklash (FileZilla)
Control panel → **FTP Accounts** dan FTP host/user/parol oling.
**FileZilla** (tekin) o'rnatib, ulanib oling. Server tomonda `htdocs/` papkasiga kiring.

Fayllarni shunday joylang:

```
htdocs/                          ← web/ ICHIDAGI hamma narsa shu yerga
├── index.php                    ← deploy/index.php (web/index.php EMAS!)
├── .htaccess                    ← web/.htaccess
├── css/  js/  img/  audio/  assets/   ← web/ ichidagilar
└── app/                         ← loyihaning QOLGAN hammasi shu yerga
    ├── vendor/   (46MB — sabr bilan yuklang, ~20-40 daq)
    ├── config/   (db.php — 4-bosqichdagi to'ldirilgan)
    ├── controllers/  models/  views/  migrations/  modules/  commands/  assets/
    ├── runtime/  (bo'sh, lekin YOZISH huquqli bo'lsin)
    └── .htaccess  ← deploy/app.htaccess (framework'ni himoya qiladi)
```

Qisqacha:
- **`web/` ichidagi hamma fayl** → `htdocs/` (ildizga). Lekin `index.php` o'rniga `deploy/index.php` ni qo'ying.
- **Qolgan barcha papka/fayl** (vendor, config, controllers, models, views, migrations, modules, commands, assets, yii, composer.json) → `htdocs/app/` ga.
- `deploy/app.htaccess` → `htdocs/app/.htaccess` nomi bilan.
- `htdocs/app/runtime/` papkasi mavjud va yozish huquqli (CHMOD 755/777) bo'lsin.
- `htdocs/assets/` papkasi ham yozish huquqli bo'lsin (Yii shu yerga asset chiqaradi).

## 6. Tekshirish
- `https://sizning-subdomeningiz.infinityfreeapp.com` ni oching.
- Alifbo, darslar, talaffuz, ovoz — hammasi ishlashi kerak.
- Endi **mikrofon (🎤 O'qib ko'ring)** ham ishlaydi (HTTPS bo'lgani uchun).

## Muammolar bo'lsa
- **500 xato:** `htdocs/app/runtime/` yozish huquqini (CHMOD 755) tekshiring; PHP versiya 8.1+ ekanini tekshiring.
- **Baza ulanmadi:** `htdocs/app/config/db.php` dagi host/user/parol to'g'riligini tekshiring.
- **Rasm/ovoz chiqmadi:** `htdocs/css, htdocs/audio, htdocs/img` papkalari yuklanganini tekshiring.
- **Sahifa ochilmadi (faqat ildiz):** `htdocs/.htaccess` (web/.htaccess) yuklanganini tekshiring.

> Eslatma: ovoz fayllari oldindan generatsiya qilinган (lokal), shuning uchun
> internetga bog'liq emas — InfinityFree'da ham darrov ishlaydi.
