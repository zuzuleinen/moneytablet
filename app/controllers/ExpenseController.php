<?php

class ExpenseController extends BaseController {

    public function create() 
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $postData = Input::all();

            $predictionId = $postData['predictionId'];
            $expenseValue = $postData['value'];

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

}