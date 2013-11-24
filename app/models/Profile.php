<?php
/**
 * Profile class. This class is used as a model
 * for user registered with Facebook
 */
class Profile extends Eloquent {
    
    /**
     * Define many to one relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

}