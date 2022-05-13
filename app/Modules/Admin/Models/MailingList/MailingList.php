<?php

namespace App\Modules\Admin\Models\MailingList;

use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
	protected $table = 'mailing_list';
	protected $guarded = [];

    public function groups()
    {
        return $this->belongsToMany(MailingListGroup::class, 'mailing_list_mailing_list_group', 'mailing_list_id', 'mailing_list_group_id');
    }
}
