<?php

class EconomyController extends BaseController {

    public function create()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $postData = Input::all();

            $tabletId = $postData['tabletId'];
            $economyValue = (float) $postData['economyValue'];

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