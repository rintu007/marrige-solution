<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SmsContact extends Model
{
	protected $table = 'sms_contacts';

	protected $fillable = [
		'sms_contact_bulk_id',
		'directory_id',
		'verified_phone'
  ];

  public function directory()
  {
  	return $this->belongsTo('App\Model\WebDirectory','directory_id');
  }
}
