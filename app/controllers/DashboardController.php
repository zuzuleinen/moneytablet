<?php

/**
 * Dashboard controller class
 * @author Andrei Boar <andrey.boar@gmail.com>
 */
class DashboardController extends BaseController
{

    /**
     * Index action. Render dashboard with tablet
     * @return string
     */
    public function index()
    {
        $userTablet = $this->_getCurrentTablet();

        if ($userTablet) {
            $predictions = $userTablet->predictions;
            return View::make(
                    'dashboard/index', array('tablet' => $userTablet, 'predictions' => $predictions)
            );
        }
        return View::make('dashboard/info');
    }

    /**
     * Get current tablet
     * @return Tablet
     */
    protected function _getCurrentTablet()
    {
        $userId = $this->_getCurrentUser()->id;

        $tablet = new Tablet();

        return $tablet->loadByUserId($userId);
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