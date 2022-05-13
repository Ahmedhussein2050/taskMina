<?php

namespace App\Modules\Admin\Models\Services;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAttachment extends Model
{
    protected $table = 'services_attachments';
    protected $guarded = [];
    public $timestamps = false;
}
