<?php

include __DIR__ . "/../QueryBuilder.php";

QueryBuilder::getInstance()->delete('posts', ['title', '=', 'trash']);

QueryBuilder::getInstance()->insert('posts', [
    'title' => 'trash',
]);

QueryBuilder::getInstance()->update('posts', 2, [
    'title' => QueryBuilder::getInstance()->get('posts', ['id', '=', '2'])->first()['title'] . '.',
]
);

QueryBuilder::getInstance()->get('posts', ['id', '>', 0]);
$posts = QueryBuilder::getInstance()->results();

include __DIR__ . "/../index.view.php";
