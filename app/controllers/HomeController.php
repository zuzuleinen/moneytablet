<?php

/**
 * Home controller class
 */
class HomeController extends BaseController
{
    /**
     * Index action
     * @return Illuminate\View\View
     */
    public function index()
    {
        return View::make('home/index');
    }

}