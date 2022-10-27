<?php

/**
 * @OSHIT SUTRA DHAR
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Account extends BaseModel
{
    protected $guarded = ['id'];

    protected static $logName = 'Account';
}
