<?php

class ExpenseController extends BaseController
{

    public function create()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $postData = Input::all();

            $predictionId = $postData['predictionId'];
            $expenseValue = $postData['value'];

            $rules = array(
                'predictionId' => array('required', 'not_in:0', 'exists:predictions,id'),
                'value' => array('required', 'numeric', 'min:0')
            );

            $messages = array(
                'predictionId.required' => 'Please select a category.',
                'predictionId.not_in' => 'Please select a category.',
                'predictionId.exists' => 'An error occured. Please try later.',
                'value.required' => 'Please enter expense value.',
                'value.numeric' => 'Expense must be a numeric value. Ex: 90, 3.42',
                'value.min' => 'Value must be a positive number.'
            );

            $validator = Validator::make($postData, $rules, $messages);

            if ($validator->fails()) {
                $messages = $validator->messages();
                $response['predictionMsg'] = $messages->first('predictionId');
                $response['valueMsg'] = $messages->first('value');

                return Response::json($response);
            }

            $expense = new Expense();
            $expense->prediction_id = $predictionId;
            $expense->value = $expenseValue;
            $expense->save();

            $response['expenseId'] = $expense->id;
            $response['success'] = true;
            Event::fire('expense.create.success', array($expense));
        }

        return Response::json($response);
    }
    
    /**
     * Display all expenses from current tablet
     * for current user
     * 
     * @return View
     */
    public function all()
    {
        $userTablet = $this->_getCurrentTablet();
        
        $expense = new Expense();
        $expenses = $expense->getLastExpenses($userTablet->id);
        
        return View::make('expense/all', array(
            'expenses' => $expenses, 
            'tablet' => $userTablet
            )
        );
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
     * Get all expenses so far
     * in json format
     * 
     * @return json
     */
    public function getAllExpensesJson()
    {
        $response = array(
            array('Expense', 'Total expense'),
        );
        $prediction = new Prediction();
        $expenses = $prediction->getAllSpentPredictions(Auth::user()->id);

        if (count($expenses)) {
            foreach ($expenses as $expense) {
                $response[] = array($expense->name, (float) $expense->value);
            }
        } else {
            $response[] = array('Nothing', 0);
        }


        return Response::json($response);
    }
}