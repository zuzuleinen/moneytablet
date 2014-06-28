<?php

/**
 * Prediction controller
 * 
 * @author Andrei Boar <andrey.boar@gmail.com>
 */
class PredictionController extends BaseController {

    /**
     * Create prediction action
     * @return string
     */
    public function create()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $postData = Input::all();

            $tabletId = $postData['tabletId'];
            $predictionName = $postData['prediction'];
            $predictionValue = $postData['value'];

            $rules = array(
                'prediction' => array('required', 'max:20'),
                'value' => array('required', 'numeric', 'min:0')
            );

            $messages = array(
                'prediction.required' => 'Please enter prediction name.',
                'prediction.max' => 'Prediction name shouldn\'t be bigger than 20 chars.',
                'prediction.unique' => 'You arleady have a prediction with this name.',
                'value.required' => 'Please enter prediction value.',
                'value.numeric' => 'Prediction value must be a numeric value. Ex: 90, 3.42',
                'value.min' => 'Value must be a positive number.'
            );

            $validator = Validator::make($postData, $rules, $messages);

            if ($validator->fails()) {
                $messages = $validator->messages();
                $response['predictionMsg'] = $messages->first('prediction');
                $response['valueMsg'] = $messages->first('value');

                return Response::json($response);
            }

            $prediction = new Prediction();
            $prediction->tablet_id = $tabletId;
            $prediction->name = $predictionName;
            $prediction->predicted = $predictionValue;
            $prediction->value = $predictionValue;

            $prediction->save();

            $response['predictionId'] = $prediction->id;
            $response['success'] = true;
        }

        return Response::json($response);
    }

    /**
     * Edit prediction
     * @return string
     */
    public function edit()
    {
        $response = array(
            'success' => false,
            'balanceValue' => false
        );

        if (Request::ajax()) {
            $postData = Input::all();

            $predictionId = isset($postData['predictionId']) ? $postData['predictionId'] : null;
            $predictionName = isset($postData['predictionName']) ? $postData['predictionName'] : null;
            $predictionValue = isset($postData['predictionValue']) ? (int) $postData['predictionValue'] : null;

            $prediction = Prediction::find($predictionId);

            if (!$prediction) {
                return Response::json($response);
            }

            if ($predictionName) {
                $prediction->name = $predictionName;
                $prediction->save();
            }

            if (!is_null($predictionValue)) {
                $tabletId = $prediction->tablet_id;
                $prediction->value = $predictionValue;
                $prediction->save();
                $tablet = Tablet::find($tabletId);
                $balanceValue = $tablet->getBalance();
                $response['balanceValue'] = $balanceValue;
            }

            $response['predictionId'] = $prediction->id;
            $response['success'] = true;
        }

        return Response::json($response);
    }

    /**
     * Delete prediction action
     * @return string
     */
    public function delete()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $predictionIds = Input::get('predictionIds');
            $tabletId = null;

            if ($predictionIds) {
                $predictionIdsArray = $this->_getPredictionIdsArray($predictionIds);
                foreach ($predictionIdsArray as $predictionId) {
                    $prediction = Prediction::find($predictionId);
                    if (!$tabletId) {
                        $tablet = Tablet::find($prediction->tablet_id);
                    }

                    $predictionExpenses = $prediction->expenses;
                    foreach ($predictionExpenses as $expense) {
                        $tablet->total_expenses = $tablet->total_expenses - $expense->value;
                        $tablet->current_sum = $tablet->current_sum + $expense->value;
                    }
                    $tablet->save();
                }

                Prediction::destroy($predictionIdsArray);
                $response['success'] = true;
            }
        }

        return Response::json($response);
    }

    /**
     * Get array of prediction ids from request string
     * @param string $predictionIds ex. '9.8.7.'
     * @return array
     */
    private function _getPredictionIdsArray($predictionIds)
    {
        $predictionIdsArr = explode('.', $predictionIds);
        array_pop($predictionIdsArr);

        return $predictionIdsArr;
    }

}
