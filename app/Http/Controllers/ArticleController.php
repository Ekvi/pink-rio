<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\MenuRepository;
use Corp\Repositories\PortfolioRepository;

class ArticleController extends SiteController
{
    public function __construct(ArticleRepository $a_rep, PortfolioRepository $p_rep)
    {
        parent::__construct(new MenuRepository(new Menu()));

        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    }

    public function index()
    {
        /*$portfolios = $this->getPortfolio();
        $content = view(env('THEME') . '.content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $sliderItems = $this->getSlider();
        $slider = view(env('THEME') . '.slider')->with('slider', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'slider', $slider);

        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME') . '.indexBar')->with('articles', $articles)->render();

        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';*/

        $articles = $this->getArticles();
        $content = view(env('THEME') . '.article_content')->with('articles', $articles)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    private function getArticles($alias = false)
    {
        $articles = $this->a_rep->get(['id', 'title', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id'], false, true);


        if($articles) {
            //$articles->load('users', 'categories', 'comments');
        }

        return $articles;
    }
}