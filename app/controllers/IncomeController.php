<?php

class IncomeController extends BaseController {

    public function create()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $postData = Input::all();

            $tabletId = $postData['tabletId'];
            $incomeValue = (float) $postData['incomeValue'];
            
            $rules = array(
                'tabletId' => array('required', 'not_in:0', 'exists:tablets,id'),
                'incomeValue' => array('required', 'numeric', 'min:0')
            );

            $messages = array(
                'tabletId.required' => 'Please select a tablet.',
                'tabletId.not_in' => 'Please select a tablet.',
                'tabletId.exists' => 'An error occured. Please try later.',
                'incomeValue.required' => 'Please enter income value.',
                'incomeValue.numeric' => 'Income must be a numeric value. Ex: 90, 3.42',
                'incomeValue.min' => 'Income must have a positive value.'
            );

            $validator = Validator::make($postData, $rules, $messages);

            if ($validator->fails()) {
                $messages = $validator->messages();
                $response['tabletMsg'] = $messages->first('tabletId');
                $response['incomeValueMsg'] = $messages->first('incomeValue');

                return Response::json($response);
            }

            $tablet = Tablet::find($tabletId);

            if ($tablet->id) {
                $initialIncomeValue = (float) $tablet->total_amount;
                $tablet->total_amount = $initialIncomeValue + $incomeValue;
                $tablet->save();

                $response['success'] = true;
                Event::fire('income.create.success', array($incomeValue, $tabletId));
            }
        }

        return Response::json($response);
    }

}
