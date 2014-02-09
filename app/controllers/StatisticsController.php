<?php

/**
 * Statistics controller
 */
class StatisticsController extends BaseController {

    /**
     * Show statistics overview
     * 
     * @return View
     */
    public function overview()
    {
        $tablets = $this->_getCurrentUser()->tablets()->where('is_active', '=', 0);
        
        $viewData['allowToViewStatistics'] = (count($tablets) > 1) ? true : false;
        
        return View::make('statistics/overview', $viewData);
    }

    /**
     * Get main statistics
     * 
     * @return json
     */
    public function getStatistics()
    {
        $response['incomes'] = array(array('Tablet', 'Income'));
        $response['expenses'] = array(array('Tablet', 'Expense'));
        $response['savings'] = array(array('Tablet', 'Savings'));

        $tablets = $this->_getCurrentUser()->tablets;

        foreach ($tablets as $tablet) {
            $response['incomes'][] = array($tablet->name, (int) $tablet->total_amount);
            $response['expenses'][] = array($tablet->name, (int) $tablet->total_expenses);
            $response['savings'][] = array($tablet->name, (int) $tablet->economies);
        }

        return Response::json($response);
    }

}
