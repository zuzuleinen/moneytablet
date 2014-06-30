<?php

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        $tabletsSoFar = count($this->_getCurrentUser()->tablets()->getResults());
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout, array('tabletsSoFar' => $tabletsSoFar));
        }
    }

    /**
     * Get current user
     * @return User
     */
    protected function _getCurrentUser()
    {
        return Auth::user();
    }

}