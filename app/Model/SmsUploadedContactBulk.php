<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SmsUploadedContactBulk extends Model
{
  protected $table = 'sms_uploaded_contact_bulks';

	protected $fillable = [
		'sent_from',
		'addedby_id',
		'title',
		'message',
		'status'
  ];

  public function contacts()
  {
  	return $this->hasMany('App\Model\SmsUploadedContact', 'sms_uploaded_contact_bulk_id');
  }
}
