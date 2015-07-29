<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Room extends Eloquent
{
	    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms';

    /**
     * Add auditable events.
     *
     * @var string
     */
    public static function boot()
    {
        parent::boot();
        Room::observe(new AuditableObserver);
    }
    
}