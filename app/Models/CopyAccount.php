<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopyAccount extends Model
{
    use HasFactory;
    protected $table = 'tblaccount_copy';
    protected $primaryKey = 'intID';

}
