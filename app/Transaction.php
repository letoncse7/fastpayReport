<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Each transaction belongs to a sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id', 'id')->select('id', 'name', 'mobile_no', 'account_no');
    }

    /**
     * Each transaction belongs to a receiver
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id', 'id')->select('id', 'name', 'mobile_no', 'account_no');
    }

    /**
     * A transaction has one or more histories
     */
    public function histories()
    {
        return $this->hasMany('App\History');
    }

    public function statements()
    {
        return $this->hasMany(Statement::class);
    }

    /**
     * Each transaction belongs to a type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function txType()
    {
        return $this->belongsTo('App\TransactionType', 'type', 'id')->select('id', 'name', 'is_printable');
    }

    /**
     * Each transaction belongs to a status
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function txStatus()
    {
        return $this->belongsTo('App\TransactionStatus', 'status', 'id');
    }

    public function slipHistories(){
        return $this->hasMany(SlipHistory::class,'tx_id');
    }

    /**
     * Return logged-in users transactions
     * @param $query
     * @return mixed
     */
    public function scopeMyTransactions($query)
    {
        return $query->where(function($sql) {
            $sql->where('transactions.sender_id', auth()->user()->id)
                ->orWhere('transactions.receiver_id', auth()->user()->id);
        });
    }

    /**
     * A transaction may have a commission
     */
    public function commission()
    {
        return $this->belongsTo('App\Commission');
    }

    public function backupStatements()
    {
        return $this->hasMany(BackupStatement::class);
    }
}
