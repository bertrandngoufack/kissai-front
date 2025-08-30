<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'CI Portal') ?></title>
    <link rel="stylesheet" href="/css/bulma.min.css">
    <style>
        .container { padding-top: 2rem; }
    </style>
    <?= $this->renderSection('head') ?>
    </head>
<body>
    <section class="section">
        <div class="container">
            <h1 class="title"><?= esc($title ?? 'CI Portal') ?></h1>
            <?= $this->renderSection('content') ?>
        </div>
    </section>
    <?= $this->renderSection('scripts') ?>
</body>
</html>

