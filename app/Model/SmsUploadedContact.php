<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SmsUploadedContact extends Model
{
  protected $table = 'sms_uploaded_contacts';

	protected $fillable = [

		'sms_uploaded_contact_bulk_id',
		'mobile',
		'status',
		'addedby_id',
		'name',
		'company',
		'area',
  ];

  public function bulk()
  {
  	return $this->belongsTo('App\Model\SmsUploadedContactBulk', 'sms_uploaded_contact_bulk_id');
  }
}
