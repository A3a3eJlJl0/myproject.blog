<?php include __DIR__ . '/../header.php'; ?>
    <h1> <?= $article->getName(); ?> </h1>
    <p> <?= $article->getParsedText(); ?> </p>
    <p> Автор: <?= $article->getAuthor()->getNickname(); ?> </p>
    <?php if (\MyProject\Services\UserAuthService::getUserByToken()): ?>
        <p><a href="<?= $_SERVER['REQUEST_URI'] ?>/edit"> Редактировать </a></p>
    <?php endif ?>
<?php include __DIR__ . '/../footer.php'; ?>