<?php

namespace Corp\Repositories;

use Corp\Article;

class ArticleRepository extends Repository
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }
}