<?php

/**
 * Prediction class
 * @author Andrei Boar <andrey.boar@gmail.com>
 */
class Prediction extends Eloquent
{

    /**
     * Define an inverse one-to-one relationship
     * with Tablet model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tablet()
    {
        return $this->belongsTo('Tablet');
    }

    /**
     * Define one-to-many relationship with expenses
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany('Expense');
    }

    /**
     * Get sum of total expenses
     * @return string
     */
    public function getTotalExpenses()
    {
        return $this->expenses()->sum('value');
    }

    /**
     * Get predictions by term
     * Here we should add a filter based on user id
     * 
     * @param string $term
     * @param int $userId
     * @return array
     */
    public function getBySuggestedTerm($term, $userId = null)
    {
        return $this->select('name')
                ->where('name', 'like', '%' . $term . '%')
                ->distinct()
                ->get();
    }

    /**
     * Get all predictions spent so far
     * @param int $userId
     * @return string
     */
    public function getAllSpentPredictions($userId)
    {
        return DB::select("SELECT `predictions`.name , sum(ex.expenseValue) as value
FROM `predictions` 
INNER JOIN (SELECT prediction_id, sum(value) as expenseValue from expenses GROUP BY prediction_id) ex
ON `predictions`.id = ex.prediction_id
WHERE `predictions` .tablet_id in (select id from tablets where user_id = $userId)
group by name
ORDER BY value DESC
;");
    }
}

