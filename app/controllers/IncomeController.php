<?php

class IncomeController extends BaseController {

    public function create()
    {
        $response = array('success' => false);

        if (Request::ajax()) {
            $postData = Input::all();

            $tabletId = $postData['tabletId'];
            $incomeValue = (float) $postData['incomeValue'];

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
