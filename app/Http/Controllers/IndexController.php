<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Repositories\MenuRepository;
use Corp\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class IndexController extends SiteController
{
    public function __construct(SliderRepository $s_rep)
    {
        parent::__construct(new MenuRepository(new Menu()));

        $this->s_rep = $s_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.index';
    }

    public function index()
    {
        $sliderItems = $this->getSlider();

        $slider = view(env('THEME') . '.slider')->with('slider', $sliderItems)->render();

        $this->vars = array_add($this->vars, 'slider', $slider);

        return $this->renderOutput();
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
