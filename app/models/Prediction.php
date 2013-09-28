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
}