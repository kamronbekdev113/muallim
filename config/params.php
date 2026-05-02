<?php
return [
    'adminEmail' => 'admin@muallim.uz',
    'xpPerLesson' => 20,
    'xpPerTest' => 50,
    'xpPerLetterPractice' => 5,
    'xpDailyStreak' => 10,
    'levels' => [
        ['name' => 'Yangi Talaba',    'min_xp' => 0,    'color' => '#6c757d', 'badge' => 'secondary'],
        ['name' => 'Alifbo Biluvchi', 'min_xp' => 200,  'color' => '#17a2b8', 'badge' => 'info'],
        ['name' => "Qori",            'min_xp' => 500,  'color' => '#28a745', 'badge' => 'success'],
        ['name' => 'Mudarris',        'min_xp' => 1000, 'color' => '#fd7e14', 'badge' => 'warning'],
        ['name' => 'Hofiz',           'min_xp' => 2000, 'color' => '#6f42c1', 'badge' => 'purple'],
        ['name' => 'Muallim',         'min_xp' => 4000, 'color' => '#C9A84C', 'badge' => 'gold'],
    ],
];
