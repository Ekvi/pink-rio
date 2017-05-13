<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenuRepository;
//use Lavary\Menu\Menu;
use Illuminate\Support\Facades\URL;
use Menu;

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

        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        return view($this->template)->with($this->vars);
    }

    private function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {
            foreach($menu as $item) {
                if($item->parent_id == 0) {
                    $m->add($item->title, URL::to('/') . $item->path)->id($item->id);
                } else {
                    if($m->find($item->parent_id)) {
                        $m->find($item->parent_id)->add($item->title, URL::to('/') . $item->path)->id($item->id);
                    }
                }
            }
        });

        //dd($mBuilder);

        return $mBuilder;
    }
}
