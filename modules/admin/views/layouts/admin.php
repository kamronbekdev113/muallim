<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title ?? 'Admin') ?> | Muallim Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root { --sidebar-w: 240px; --header-h: 56px; --green:#1B4332; --gold:#C9A84C; }
        body { background: #f4f6f9; font-family: 'Montserrat', sans-serif; margin: 0; }
        .admin-sidebar {
            width: var(--sidebar-w); position: fixed; top:0; left:0; bottom:0;
            background: var(--green);
            overflow-y: auto; z-index: 200;
            box-shadow: 2px 0 20px rgba(0,0,0,0.15);
        }
        .sidebar-brand {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid rgba(201,168,76,0.2);
            display: flex; align-items: center; gap: 0.6rem;
        }
        .sidebar-brand-icon {
            width: 34px; height: 34px; background: var(--gold);
            color: var(--green); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; font-weight: 700;
        }
        .sidebar-brand-text { color:#fff; font-weight:700; font-size:0.95rem; }
        .sidebar-section { padding: 0.75rem 0.5rem 0.25rem 1rem; font-size:0.65rem; text-transform:uppercase; letter-spacing:0.1em; color:rgba(255,255,255,0.4); font-weight:600; }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.55rem 1.25rem; color: rgba(255,255,255,0.75);
            text-decoration: none; font-size: 0.85rem; font-weight:500;
            border-radius: 0; transition: all 0.15s;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(201,168,76,0.12);
            color: var(--gold);
            border-left-color: var(--gold);
        }
        .sidebar-link i { width:18px; text-align:center; font-size:0.9rem; }
        .admin-header {
            position: fixed; top:0; left: var(--sidebar-w); right:0;
            height: var(--header-h); background: #fff;
            border-bottom: 1px solid #e9ecef;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 1.5rem; z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .admin-header .page-title { font-weight: 700; font-size: 1rem; color: #1B4332; }
        .header-user { display: flex; align-items: center; gap: 0.75rem; font-size:0.85rem; color:#555; }
        .admin-main {
            margin-left: var(--sidebar-w);
            margin-top: var(--header-h);
            padding: 1.75rem;
            min-height: calc(100vh - var(--header-h));
        }
        /* Admin cards */
        .admin-card {
            background: #fff; border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 1.5rem;
        }
        .admin-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: space-between;
            font-weight: 700; font-size: 0.9rem; color: var(--green);
        }
        .admin-card-body { padding: 1.25rem; }
        /* Stats */
        .stat-mini {
            background: #fff; border-radius: 12px; border: 1px solid #e9ecef;
            padding: 1.25rem; text-align: center;
        }
        .stat-mini-num { font-size: 2rem; font-weight: 800; color: var(--green); }
        .stat-mini-label { font-size: 0.75rem; color: #888; }
        /* Table */
        .admin-table { width:100%; border-collapse: collapse; font-size:0.85rem; }
        .admin-table th { background: #f8f9fa; color:#495057; font-weight:600; padding:0.65rem 0.9rem; border-bottom:2px solid #dee2e6; text-align:left; }
        .admin-table td { padding:0.6rem 0.9rem; border-bottom:1px solid #f0f0f0; color:#343a40; vertical-align:middle; }
        .admin-table tr:hover td { background:#f8fffe; }
        .arabic-cell { font-family:'Noto Naskh Arabic','Amiri',serif; font-size:1.3rem; direction:rtl; }
        /* Action buttons */
        .btn-action { padding:4px 10px; border-radius:6px; font-size:0.78rem; font-weight:600; cursor:pointer; border:none; transition:all 0.15s; }
        .btn-edit { background:#e8f5e9; color:#1B4332; }
        .btn-edit:hover { background:#1B4332; color:#fff; }
        .btn-delete { background:#fdecea; color:#c62828; }
        .btn-delete:hover { background:#c62828; color:#fff; }
        /* Form */
        .form-control { border-radius:8px; border:1.5px solid #dee2e6; font-size:0.88rem; }
        .form-control:focus { border-color:var(--green); box-shadow:0 0 0 3px rgba(27,67,50,0.1); }
        .btn-save { background:var(--green); color:#fff; border:none; border-radius:8px; padding:0.55rem 1.5rem; font-weight:600; cursor:pointer; }
        .btn-save:hover { background:#2D6A4F; }
        /* Flash */
        .alert { border-radius:10px; }
        /* Badges */
        .badge-active { background:#d1e7dd; color:#0f5132; border-radius:20px; padding:2px 10px; font-size:0.72rem; font-weight:600; }
        .badge-inactive { background:#f8d7da; color:#842029; border-radius:20px; padding:2px 10px; font-size:0.72rem; font-weight:600; }
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">م</div>
        <span class="sidebar-brand-text">Muallim Admin</span>
    </div>
    <div class="sidebar-section">Asosiy</div>
    <a href="<?= Url::to(['/admin']) ?>" class="sidebar-link"><i class="fas fa-home"></i> Dashboard</a>

    <div class="sidebar-section">Kontent</div>
    <a href="<?= Url::to(['/admin/letter']) ?>" class="sidebar-link"><i class="fas fa-font"></i> Harflar</a>
    <a href="<?= Url::to(['/admin/chapter']) ?>" class="sidebar-link"><i class="fas fa-layer-group"></i> Boblar</a>
    <a href="<?= Url::to(['/admin/lesson']) ?>" class="sidebar-link"><i class="fas fa-book-open"></i> Darslar</a>
    <a href="<?= Url::to(['/admin/vocabulary']) ?>" class="sidebar-link"><i class="fas fa-list"></i> Lug'at</a>
    <a href="<?= Url::to(['/admin/tajweed']) ?>" class="sidebar-link"><i class="fas fa-star-and-crescent"></i> Tajvid</a>

    <div class="sidebar-section">Quron</div>
    <a href="<?= Url::to(['/admin/surah']) ?>" class="sidebar-link"><i class="fas fa-quran"></i> Suralar</a>
    <a href="<?= Url::to(['/admin/ayah']) ?>" class="sidebar-link"><i class="fas fa-align-left"></i> Oyatlar</a>

    <div class="sidebar-section">Testlar & Foydalanuvchilar</div>
    <a href="<?= Url::to(['/admin/quiz']) ?>" class="sidebar-link"><i class="fas fa-question-circle"></i> Testlar</a>
    <a href="<?= Url::to(['/admin/user']) ?>" class="sidebar-link"><i class="fas fa-users"></i> Foydalanuvchilar</a>

    <div style="padding:1rem 1.25rem; margin-top:auto; border-top:1px solid rgba(255,255,255,0.1);">
        <a href="<?= Url::to(['/']) ?>" class="sidebar-link" style="padding:0.5rem 0;">
            <i class="fas fa-arrow-left"></i> Saytga qaytish
        </a>
    </div>
</aside>

<!-- Header -->
<header class="admin-header">
    <div class="page-title"><?= Html::encode($this->title ?? 'Admin Panel') ?></div>
    <div class="header-user">
        <span><i class="fas fa-user-shield text-success"></i> <?= Html::encode(Yii::$app->user->identity->username) ?></span>
        <a href="<?= Url::to(['/chiqish']) ?>" data-method="post" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-sign-out-alt"></i> Chiqish
        </a>
    </div>
</header>

<!-- Main -->
<main class="admin-main">
    <?php foreach (['success','error','info','warning'] as $t): ?>
        <?php if (Yii::$app->session->hasFlash($t)): ?>
            <div class="alert alert-<?= $t === 'error' ? 'danger' : $t ?> alert-dismissible">
                <?= Yii::$app->session->getFlash($t) ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= $content ?>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
