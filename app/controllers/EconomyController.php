<?php

class EconomyController extends BaseController {

    public function create()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $postData = Input::all();

            $tabletId = $postData['tabletId'];
            $economyValue = (float) $postData['economyValue'];

            $rules = array(
                'tabletId' => array('required', 'not_in:0', 'exists:tablets,id'),
                'economyValue' => array('required', 'numeric', 'min:0')
            );

            $messages = array(
                'tabletId.required' => 'Please select a tablet.',
                'tabletId.not_in' => 'Please select a tablet.',
                'tabletId.exists' => 'An error occured. Please try later.',
                'economyValue.required' => 'Please enter savings value.',
                'economyValue.numeric' => 'Savings must be a numeric value. Ex: 90, 3.42',
                'economyValue.min' => 'Savings must have a positive value.'
            );

            $validator = Validator::make($postData, $rules, $messages);

            if ($validator->fails()) {
                $messages = $validator->messages();
                $response['tabletMsg'] = $messages->first('tabletId');
                $response['economyValueMsg'] = $messages->first('economyValue');

                return Response::json($response);
            }

            $tablet = Tablet::find($tabletId);

            if ($tablet->id) {
                $initialCurrentSum = $tablet->current_sum;
                $tablet->current_sum = $initialCurrentSum - $economyValue;

                $initialEconomies = $tablet->economies;
                $tablet->economies = $initialEconomies + $economyValue;

                $tablet->save();

                $response['success'] = true;
                Event::fire('economy.create.success', array($economyValue, $tabletId));
            }
        }

        return Response::json($response);
    }

}