<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Event extends Eloquent
{
	    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * Add auditable events.
     *
     * @var string
     */
    public static function boot()
    {
        parent::boot();
        Event::observe(new AuditableObserver);
    }
    
}