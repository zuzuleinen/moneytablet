<?php

/**
 * Tablet controller class
 *
 * @author Andrei Boar <andrei.boar@gmail.com>
 */
class TabletController extends BaseController {

    /**
     * Tablet create action
     * @return string
     */
    public function create()
    {
        $suggestedName = date('F Y');
        $totalTablets = count($this->_getCurrentUser()->tablets);

        return View::make(
                'tablet/create', array('tabletName' => $suggestedName, 'totalTablets' => $totalTablets)
        );
    }

    public function createPost()
    {
        $postData = Input::all();

        //@TODO I should make the tablet name unique for user
        $rules = array(
            'name' => array('required'),
            'amount' => array('required', 'numeric'),
            'economies' => array('numeric')
        );

        $messages = array(
            'name.required' => 'Please enter your tablet name.',
            'amount.required' => 'Please enter your tablet amount.',
            'amount.numeric' => 'Amount must be a numeric value. Ex: 90, 3.42',
            'economies.numeric' => 'Savings field must be a numeric value. Ex: 90, 3.42'
        );

        $validator = Validator::make($postData, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('tablet/create')
                    ->withErrors($validator)
                    ->with('amount', $postData['amount']);
        }

        $recurrentPredictions = isset($postData['recurrent_predictions']) ? true : false;

        $tablet = new Tablet();
        $tablet->user_id = Auth::user()->id;
        $tablet->name = $postData['name'];
        $tablet->total_amount = $postData['amount'];
        $tablet->current_sum = $postData['amount'];
        $tablet->economies = $postData['economies'];
        $tablet->is_active = 1;
        $tablet->save();

        if ($recurrentPredictions) {
            $this->_populateTabletWithPreviousData($tablet);
        }

        return Redirect::to('dashboard');
    }

    protected function _populateTabletWithPreviousData($newTablet)
    {
        $lastInactiveTablet = $this->_getCurrentUser()->getLastInactiveTablet();

        $oldPredictions = $lastInactiveTablet->predictions;

        if (count($oldPredictions)) {
            foreach ($oldPredictions as $oldPrediction) {
                $prediction = new Prediction();
                $prediction->tablet_id = $newTablet->id;
                $prediction->name = $oldPrediction->name;
                $startingSum = ($oldPrediction->getTotalExpenses()) ? $oldPrediction->getTotalExpenses() : $oldPrediction->predicted;

                $prediction->predicted = $startingSum;
                $prediction->value = $startingSum;
                $prediction->save();
            }
        }
    }

    /**
     * Close tablet action
     * @return string
     */
    public function close()
    {
        $response = array('success' => false);

        $tabletId = Input::get('tabletId');

        if ($tabletId) {
            $tablet = Tablet::find($tabletId);
            $tablet->is_active = 0;
            $tablet->save();
            $response['success'] = true;
            Session::put('closedTabletId', $tablet->id);
        }

        return Response::json($response);
    }

    /**
     * Tablet close success page
     * @return string
     */
    public function closeSuccess()
    {
        if (Session::has('closedTabletId')) {
            $closedTabletId = Session::get('closedTabletId');
            $tablet = Tablet::find($closedTabletId);

            return View::make('tablet/close_success', array('tablet' => $tablet));
        }

        return Redirect::to('dashboard');
    }

}
