<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="uz" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Muallim — Arab tilini 0'dan Quron qiroatigacha o'rgatuvchi platforma">
    <title><?= Html::encode($this->title ?? 'Muallim') ?> | Muallim</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- NAVBAR -->
<nav class="muallim-navbar navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="<?= Url::to(['/']) ?>">
            <span class="brand-icon">م</span>
            <span class="brand-text">Muallim</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu">
            <span><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/alifbo']) ?>">
                        <i class="fas fa-font"></i> Alifbo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/darslar']) ?>">
                        <i class="fas fa-book-open"></i> Darslar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/tajvid']) ?>">
                        <i class="fas fa-star-and-crescent"></i> Tajvid
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/mushaf']) ?>">
                        <i class="fas fa-quran"></i> Mushaf
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/namoz']) ?>">
                        <i class="fas fa-mosque"></i> Namoz
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-flex align-items-center mr-1">
                    <button id="themeToggle" class="theme-toggle-btn" title="Tungi/Kunduzgi rejim">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                </li>
                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/kirish']) ?>"><i class="fas fa-sign-in-alt"></i> Kirish</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-gold ml-2" href="<?= Url::to(['/royxat']) ?>">Ro'yxatdan o'tish</a>
                    </li>
                <?php else: ?>
                    <?php $user = Yii::$app->user->identity; ?>
                    <?php if ($user->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['/admin']) ?>"><i class="fas fa-cog"></i> Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-nav" href="#" data-toggle="dropdown">
                            <span class="user-avatar"><?= mb_strtoupper(mb_substr($user->username, 0, 1)) ?></span>
                            <span class="user-name"><?= Html::encode($user->username) ?></span>
                            <span class="xp-badge"><?= $user->xp ?> XP</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header">
                                <div class="level-name" style="color:<?= $user->getLevelInfo()['color'] ?>">
                                    <?= $user->getLevelInfo()['name'] ?>
                                </div>
                                <div class="progress mt-1" style="height:4px">
                                    <div class="progress-bar" style="width:<?= $user->getLevelProgress() ?>%;background:<?= $user->getLevelInfo()['color'] ?>"></div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= Url::to(['/profil']) ?>"><i class="fas fa-user"></i> Profilim</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq']) ?>"><i class="fas fa-dumbbell"></i> Barcha mashqlar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/harflar']) ?>"><i class="fas fa-cards-blank"></i> Flashcard</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/talaffuz']) ?>"><i class="fas fa-microphone"></i> Talaffuz</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/harakat']) ?>"><i class="fas fa-font"></i> Harakat</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/tajvid-test']) ?>"><i class="fas fa-palette"></i> Tajvid testi</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/lugat']) ?>"><i class="fas fa-book"></i> Lug'at</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/xotira']) ?>"><i class="fas fa-brain"></i> Xotira o'yini</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/tez-quiz']) ?>"><i class="fas fa-bolt"></i> Tez Quiz</a>
                            <a class="dropdown-item" href="<?= Url::to(['/mashq/gapirish']) ?>"><i class="fas fa-microphone-alt"></i> Gapirish</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="<?= Url::to(['/chiqish']) ?>"
                               data-method="post"><i class="fas fa-sign-out-alt"></i> Chiqish</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- FLASH MESSAGES -->
<?php if (Yii::$app->session->hasFlash('success')): ?>
<div class="alert-toast alert-toast-success">
    <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
    <button type="button" class="close-toast">&times;</button>
</div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
<div class="alert-toast alert-toast-error">
    <i class="fas fa-exclamation-circle"></i> <?= Yii::$app->session->getFlash('error') ?>
    <button type="button" class="close-toast">&times;</button>
</div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('info')): ?>
<div class="alert-toast alert-toast-info">
    <i class="fas fa-info-circle"></i> <?= Yii::$app->session->getFlash('info') ?>
    <button type="button" class="close-toast">&times;</button>
</div>
<?php endif; ?>

<!-- MAIN CONTENT -->
<main class="muallim-main">
    <?= $content ?>
</main>

<!-- FOOTER -->
<footer class="muallim-footer">
    <div class="footer-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="footer-brand">
                    <span class="brand-icon-lg">م</span>
                    <h4>Muallim</h4>
                    <p>Arab tilini 0'dan Quron qiroatigacha o'rgatuvchi O'zbek platformasi.</p>
                </div>
            </div>
            <div class="col-md-4">
                <h6>O'rganish</h6>
                <ul class="footer-links">
                    <li><a href="<?= Url::to(['/alifbo']) ?>">Arab alifbosi</a></li>
                    <li><a href="<?= Url::to(['/darslar']) ?>">Muallimi Soniy</a></li>
                    <li><a href="<?= Url::to(['/tajvid']) ?>">Tajvid qoidalari</a></li>
                    <li><a href="<?= Url::to(['/mushaf']) ?>">Tajvidli mushaf</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Mashqlar</h6>
                <ul class="footer-links">
                    <li><a href="<?= Url::to(['/mashq/harflar']) ?>">Harf flashcard</a></li>
                    <li><a href="<?= Url::to(['/mashq/shakl']) ?>">Shakl mashqi</a></li>
                    <li><a href="<?= Url::to(['/mashq/talaffuz']) ?>">Talaffuz mashqi</a></li>
                    <li><a href="<?= Url::to(['/mashq/boglash']) ?>">Bog'lanish mashqi</a></li>
                    <li><a href="<?= Url::to(['/mashq/soz-test']) ?>">So'z mashqi</a></li>
                    <li><a href="<?= Url::to(['/namoz']) ?>">Namoz vaqtlari</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="arabic-phrase">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
            <p>&copy; <?= date('Y') ?> Muallim &mdash; Arab tili platformasi</p>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
