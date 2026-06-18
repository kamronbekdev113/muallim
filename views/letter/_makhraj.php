<?php
/** @var string $zone  Faol maxraj sohasi kaliti */
/** @var string $title Maxraj nomi */
$points = [
    'lips'          => [78, 168],
    'lip_teeth'     => [96, 152],
    'between_teeth' => [104, 150],
    'tongue_teeth'  => [108, 148],
    'teeth_whistle' => [100, 162],
    'tongue_tip'    => [132, 170],
    'tongue_mid'    => [176, 160],
    'tongue_edge'   => [165, 180],
    'tongue_back'   => [210, 164],
    'throat_up'     => [228, 172],
    'throat_mid'    => [233, 206],
    'throat_low'    => [235, 240],
];
$a = $points[$zone] ?? [235, 240];
?>
<svg viewBox="0 0 360 310" style="width:100%;max-width:400px;display:block;margin:.5rem auto 0" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <radialGradient id="mkSkin" cx="55%" cy="40%" r="70%">
            <stop offset="0%" stop-color="#fdf6e6"/><stop offset="100%" stop-color="#f0e2c0"/>
        </radialGradient>
    </defs>

    <!-- Bosh profili (chapga qaragan) -->
    <path d="M205,32 Q120,38 96,96 Q92,112 60,136 Q92,150 84,160
             Q78,166 86,174 Q98,196 120,214 Q132,250 138,305
             L242,305 Q258,225 282,168 Q300,150 285,150
             Q300,90 250,52 Q230,34 205,32 Z"
          fill="url(#mkSkin)" stroke="#cBA86a" stroke-width="2.5" stroke-linejoin="round"/>

    <!-- Burun ichi bo'shlig'i -->
    <path d="M100,118 Q128,116 138,132 L120,140 Q104,134 100,118 Z" fill="#f3e6c4" stroke="#d8c79a" stroke-width="1"/>
    <!-- Yuqori tanglay (qattiq + yumshoq) -->
    <path d="M104,150 Q165,138 214,152" fill="none" stroke="#c9a84c" stroke-width="2" opacity=".65"/>
    <!-- Kichik til (uvula) -->
    <path d="M214,152 q5,12 -2,21" fill="none" stroke="#c9a84c" stroke-width="2.5" stroke-linecap="round"/>
    <!-- Til -->
    <path d="M104,178 Q165,140 212,166 Q224,188 150,196 Q118,196 104,186 Z"
          fill="#e69a9a" stroke="#cf8585" stroke-width="1.5" stroke-linejoin="round" opacity=".92"/>
    <path d="M150,168 Q180,160 205,170" fill="none" stroke="#cf8585" stroke-width="1" opacity=".6"/>
    <!-- Old tishlar (yuqori + pastki) -->
    <g stroke="#a99a6a" stroke-width="3" stroke-linecap="round" opacity=".8">
        <path d="M92,144 l0,11"/><path d="M99,143 l0,12"/><path d="M106,144 l0,11"/>
        <path d="M95,176 l0,-9"/><path d="M102,177 l0,-9"/>
    </g>
    <!-- Lablar -->
    <path d="M70,156 Q56,168 70,180" fill="none" stroke="#c97b7b" stroke-width="6" stroke-linecap="round"/>
    <!-- Bo'g'iz (halqum) yo'li -->
    <path d="M224,160 Q244,205 232,258" fill="none" stroke="#c9a84c" stroke-width="14" opacity=".12" stroke-linecap="round"/>
    <path d="M224,160 Q244,205 232,258" fill="none" stroke="#c9a84c" stroke-width="2" opacity=".4" stroke-dasharray="2 4"/>

    <!-- Soha yozuvlari (xira) -->
    <g font-size="10.5" fill="#9a8a5a" font-weight="600">
        <text x="118" y="108" text-anchor="middle">burun</text>
        <text x="58" y="200" text-anchor="middle">lab</text>
        <text x="96" y="135" text-anchor="middle">tish</text>
        <text x="160" y="214" text-anchor="middle">til</text>
        <text x="255" y="210" text-anchor="start">bo'g'iz</text>
    </g>

    <!-- Barcha maxraj nuqtalari (xira) -->
    <?php foreach ($points as $p): ?>
    <circle cx="<?= $p[0] ?>" cy="<?= $p[1] ?>" r="3" fill="#1b8a4f" opacity="0.28"/>
    <?php endforeach; ?>

    <!-- Faol soha -->
    <circle cx="<?= $a[0] ?>" cy="<?= $a[1] ?>" r="16" fill="#1b8a4f" opacity="0.16">
        <animate attributeName="r" values="12;20;12" dur="1.7s" repeatCount="indefinite"/>
    </circle>
    <circle cx="<?= $a[0] ?>" cy="<?= $a[1] ?>" r="8.5" fill="#1b8a4f" stroke="#fff" stroke-width="2.5"/>
    <line x1="<?= $a[0] ?>" y1="<?= $a[1] ?>" x2="<?= $a[0] ?>" y2="<?= $a[1] - 30 ?>" stroke="#1b4332" stroke-width="1.5" opacity=".5"/>
    <rect x="<?= max(4, min(252, $a[0] - 54)) ?>" y="<?= $a[1] - 50 ?>" width="108" height="22" rx="11" fill="#1b4332"/>
    <text x="<?= max(58, min(306, $a[0])) ?>" y="<?= $a[1] - 35 ?>" text-anchor="middle"
          font-size="12.5" font-weight="700" fill="#ffe9b0"><?= \yii\helpers\Html::encode($title) ?></text>
</svg>
