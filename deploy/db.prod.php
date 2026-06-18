<?php
/**
 * PRODUCTION baza sozlamasi — InfinityFree.
 * InfinityFree control panel → "MySQL Databases" dan ma'lumotlarni oling
 * va quyidagilarni almashtiring, keyin bu faylni  htdocs/app/config/db.php  qiling.
 *
 * Misol qiymatlar (sizникi boshqacha bo'ladi):
 *   host: sqlXXX.infinityfree.com
 *   db:   if0_XXXXXXX_muallim
 *   user: if0_XXXXXXX
 *   pass: (siz o'rnatgan parol)
 */
return [
    'class'    => 'yii\db\Connection',
    'dsn'      => 'mysql:host=SQL_HOST_SHU_YERGA;dbname=DB_NOMI_SHU_YERGA',
    'username' => 'DB_USER_SHU_YERGA',
    'password' => 'DB_PAROL_SHU_YERGA',
    'charset'  => 'utf8mb4',
];
