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
                'value' => array('required', 'numeric')
            );

            $messages = array(
                'prediction.required' => 'Please enter prediction name.',
                'prediction.max' => 'Prediction name shouldn\'t be bigger than 20 chars.',
                'prediction.unique' => 'You arleady have a prediction with this name.',
                'value.required' => 'Please enter prediction value.',
                'value.numeric' => 'Prediction value must be a numeric value. Ex: 90, 3.42',
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

    public function delete()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $predictionIds = Input::get('predictionIds');
            if ($predictionIds) {
                $predictionIdsArray = $this->_getPredictionIdsArray($predictionIds);
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