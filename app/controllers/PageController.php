<?php

/**
 * Page controller class
 */
class PageController extends BaseController
{

    /**
     * How to page action
     * @return Illuminate\View\View
     */
    public function howto()
    {
        return View::make('page/howto');
    }

}
