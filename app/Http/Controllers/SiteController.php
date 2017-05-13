<?php

namespace Corp\Http\Controllers;

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

    public function __construct()
    {

    }

    protected function renderOutput()
    {
        return view($this->template)->with($this->vars);
    }
}
