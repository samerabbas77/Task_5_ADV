<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = ['title','description','priority','due_date','status'];
//..........................................................................................
//..........................................................................................
    protected $guarded = ['id','created_at','updated_at','assigned_to'];

//..........................................................................................
//..........................................................................................
    // protected static function booted()
    // {
    //   // Automatically assign the authenticated user's ID on create
    //   static::creating(function ($task) {
    //     // If the user is authenticated, set the 'user_id'
    //     if (Auth::check()) 
    //     {
    //        $task->user_id = Auth::id(); // Or Auth::user()->id;
    //     }
    // });
    // }
  //..........................................................................................
//..........................................................................................


    /**
     *trans the due_date to format('d-m-Y H:i') before get it
        *Format the due_date to 'd-m-Y H:i' when retrieved from the database
     * @param mixed $value
     * @return string
     */
    public function getDueDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

//..........................................................................................
//..........................................................................................

    /**
     * set the due_date to this format 'd-m-Y H:i' before save it in database
     * 
     * Store the due_date in 'Y-m-d H:i:s' format in the database
     * @param mixed $value
     * @return void
     */
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = carbon::createFromFormat('d-m-Y H:i', $value);
    }
//..........................................................................................
//..........................................................................................

    /**
     * scope querry for prority
     * @param mixed $query
     * @param mixed $priority
     * @return mixed
     */
    public  function scopePriority($query,$priority )
    {
       return $query->where('priority', $priority);
       
    }

//..........................................................................................
//..........................................................................................
/**
 * scope querry for status
 * @param mixed $query
 * @param mixed $status
 * @return mixed
 */
public function scopeStatus($query,$status)
{
    return $query->where('status', $status);
}

//..........................................................................................
//..........................................................................................

    /**
     * one To many relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

}
