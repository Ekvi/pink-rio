<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenuRepository;

class SiteController extends Controller
{
    protected $p_rep; //portfolio repository
    protected $s_rep; //slider repository
    protected $a_rep; //article repository
    protected $m_rep; //menu repository

    protected $template;

    protected $vars = array();

    protected $contentRightBar = false;
    protected $contentLeftBar = false;

    protected $bar = false;

    public function __construct(MenuRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $menu = $this->getMenu();

        dd($menu);
        $navigation = view(env('THEME') . '.navigation')->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        return view($this->template)->with($this->vars);
    }

    private function getMenu()
    {
        $menu = $this->m_rep->get();

        return $menu;
    }
}
