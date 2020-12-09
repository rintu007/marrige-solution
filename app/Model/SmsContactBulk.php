<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SmsContactBulk extends Model
{
	protected $table = 'sms_contact_bulks';

	protected $fillable = [
		'category',
		'thana',
		'sent_from',
		'addedby_id',
		'message'
  ];

  public function contacts()
  {
  	return $this->hasMany('App\Model\SmsContact', 'sms_contact_bulk_id');
  }
}
