<div class="container">
    <?php foreach($articles as $article): ?>
        <article>
            <h3><a href="?a=view&c=post&id=<?=$article['id']?>"><?=$article['title']?></a></h3>
            <p><i>Опубликовано: <?=$article['date']?></i></p>
            <p><?=$article['content']?></p>
        </article>

    <?php endforeach ?>

</div>

