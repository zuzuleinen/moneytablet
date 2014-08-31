<?php

class Expense extends Eloquent
{

    public function getLastExpenses($tabletId, $limit = 1)
    {
        return DB::select('SELECT predictions.id, predictions.name, ex.value, ex.created_at
FROM predictions
INNER JOIN expenses as ex
ON predictions.id = ex.prediction_id
WHERE predictions.tablet_id = ' . $tabletId . '
ORDER BY ex.created_at DESC
LIMIT ' . $limit  .';');
    }

}
