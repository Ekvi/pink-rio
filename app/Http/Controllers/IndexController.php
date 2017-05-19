<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\MenuRepository;
use Corp\Repositories\PortfolioRepository;
use Corp\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class IndexController extends SiteController
{
    public function __construct(SliderRepository $s_rep, PortfolioRepository $p_rep, ArticleRepository $a_rep)
    {
        parent::__construct(new MenuRepository(new Menu()));

        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.index';
    }

    public function index()
    {
        $portfolios = $this->getPortfolio();
        $content = view(env('THEME') . '.content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $sliderItems = $this->getSlider();
        $slider = view(env('THEME') . '.slider')->with('slider', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'slider', $slider);

        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME') . '.indexBar')->with('articles', $articles)->render();

        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';

        return $this->renderOutput();
    }

    private function getArticles()
    {
        $articles = $this->a_rep->get(['alias', 'title', 'img', 'created_at'], Config::get('settings.home_article_count'));

        return $articles;
    }

    private function getSlider()
    {
        $slider = $this->s_rep->get();

        if($slider->isEmpty()) {
            return false;
        }

        $slider->transform(function($item, $key) {
            $item->img = Config::get('settings.slider_path') . '/' . $item->img;

            return $item;
        });

        return $slider;
    }

    private function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', Config::get('settings.home_portfolio_count'));

        return $portfolio;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
