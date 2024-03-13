<h2><?= esc($title) ?></h2>

<?php if (!empty($news) && is_array($news)) : ?>

    <?php foreach ($news as $news_item) : ?>

        <h3><?= esc($news_item['title']) ?></h3>

        <div class="main">
            <?= esc($news_item['body']) ?>
        </div>
        <p><a href="/news/<?= esc($news_item['description'], 'url') ?>">View article</a></p> <!-- Terhubung ke controllers News.php public function show($description = null) -->

    <?php endforeach ?>

<?php else : ?>

    <h3>No Berita</h3>

    <p>Tidak dapat menemukan berita apa pun untuk Anda.</p>

<?php endif ?>