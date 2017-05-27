<?php

namespace Corp\Http\Controllers;

use Corp\Category;
use Corp\Menu;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\CommentRepository;
use Corp\Repositories\MenuRepository;
use Corp\Repositories\PortfolioRepository;

class ArticleController extends SiteController
{
    public function __construct(ArticleRepository $a_rep, PortfolioRepository $p_rep, CommentRepository $c_rep)
    {
        parent::__construct(new MenuRepository(new Menu()));

        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;
        $this->c_rep = $c_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    }

    public function index($cat_alias = false)
    {
        $articles = $this->getArticles($cat_alias);
        $content = view(env('THEME') . '.article_content')->with('articles', $articles)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_comments'));
        $this->contentRightBar = view(env('THEME') . '.articles_bar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }

    private function getArticles($alias = false)
    {
        $where = false;

        if($alias) {
            $id = Category::select('id')->where('alias', $alias)->first()->id;
            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get(['id', 'title', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id'], false, true, $where);


        if($articles) {
            $articles->load('user', 'category', 'comments');
        }

        return $articles;
    }

    private function getComments($take)
    {
        $comments = $this->c_rep->get(['text', 'name', 'email', 'site', 'article_id', 'user_id'], $take);

        if($comments) {
            $comments->load('article', 'user');
        }

        return $comments;
    }

    private function getPortfolios($take)
    {
        $portfolios = $this->p_rep->get(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], $take);
        return $portfolios;
    }

    public function show($alias = false)
    {
        $article = $this->a_rep->one($alias, ['comments' => true]);

        if($article) {
            $article->img = json_decode($article->img);
        }

        $content = view(env('THEME') . '.article_details')->with('article', $article)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_comments'));
        $this->contentRightBar = view(env('THEME') . '.articles_bar')->with(['comments' => $comments, 'portfolios' => $portfolios])->render();

        return $this->renderOutput();
    }
}