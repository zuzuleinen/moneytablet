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
            $predictionsByValue = $userTablet->predictions()->orderBy('value', 'desc')->get();
            $predictionsByName = $userTablet->predictions()->orderBy('name', 'asc')->get();
            $expense = new Expense();
            $lastExpenses = $expense->getLastExpenses($userTablet->id, 3);
            
            return View::make('dashboard/index', array('tablet' => $userTablet, 'predictions' => $predictionsByValue, 'lastExpenses' => $lastExpenses))
                ->nest('predictionModal', 'dashboard.modal.prediction')
                ->nest('expenseModal', 'dashboard.modal.expense', array('predictions' => $predictionsByName))
                ->nest('incomeModal', 'dashboard.modal.income')
                ->nest('economyModal', 'dashboard.modal.economy')
                ->nest('closeTabletModal', 'dashboard.modal.closetablet');
        }
        
        $tabletsSoFar = count($this->_getCurrentUser()->tablets()->getResults());
        
        return View::make('dashboard/info', array('tabletsSoFar' => $tabletsSoFar));
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
}