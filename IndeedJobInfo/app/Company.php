<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'Company';
    protected $primaryKey = 'CompanyId';
    public $timestamps = false;
}
