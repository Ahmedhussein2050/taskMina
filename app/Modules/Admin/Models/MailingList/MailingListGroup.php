<?php

namespace App\Modules\Admin\Models\MailingList;

use Illuminate\Database\Eloquent\Model;

class MailingListGroup extends Model
{
	protected $table = 'mailing_list_groups';
	protected $guarded = [];

    public function emails()
    {
        return $this->belongsToMany(MailingList::class, 'mailing_list_mailing_list_group', 'mailing_list_group_id', 'mailing_list_id');
    }
}
