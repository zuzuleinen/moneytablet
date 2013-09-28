<?php

/**
 * Tablet model
 * @author Andrei Boar <andrey.boar@gmail.com>
 */
class Tablet extends Eloquent
{
    /**
     * Define one-to-many relationship with predictions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function predictions()
    {
        return $this->hasMany('Prediction');
    }

    /**
     * Load active tablet by user_id
     * @param int $userId
     * @return Tablet
     */
    public function loadByUserId($userId)
    {
        $userId = (int) $userId;
        
        return Tablet::where('user_id', $userId)->where('is_active', 1)->first();
    }
    
    /**
     * Get tablet balance
     * @return float
     */
    public function getBalance()
    {
        $currentSum = (float) $this->current_sum;
        $predictionsSum = (float) $this->predictions()->sum('value');
        
        return $currentSum - $predictionsSum;
    }
    
}