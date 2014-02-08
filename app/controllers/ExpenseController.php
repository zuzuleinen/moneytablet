<?php

class ExpenseController extends BaseController {

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

}