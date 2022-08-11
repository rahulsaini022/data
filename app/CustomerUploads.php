<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
class CustomerUploads extends Model
{
    protected $table = 'customer_uploads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','document_title', 'upload_document',
    ];


    public static function Formvalidation($request){
        Validator::make($request->all(), [
            'document_title' => 'required|max:200',
            'upload_document' => 'required|file|mimes:ppt,pptx,doc,docx,pdf,xls,xlsx|max:204800',
        ])->validate();
    }
}
