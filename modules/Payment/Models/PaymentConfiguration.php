<?php

namespace Modules\Payment\Models;

use App\Models\Tenant\ModelTenant;

class PaymentConfiguration extends ModelTenant
{

    protected $fillable = [
        'enabled_yape',
        'qrcode_yape',
        'name_yape',
        'telephone_yape',
        
        'enabled_mp',
        'access_token_mp',
        'public_key_mp',
    ];

    protected $hidden = [
        'access_token_mp'
    ];


    protected $casts = [
        'enabled_yape' => 'bool',
        'enabled_mp' => 'bool',
    ];


    public function getImageUrlYapeAttribute()
    {
        return $this->qrcode_yape ? asset('storage'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'payment_configurations'.DIRECTORY_SEPARATOR.$this->qrcode_yape) : null;
    }

    public function getRowResource()
    {
        return [
            'id' => $this->id,
            'enabled_yape' => $this->enabled_yape,
            'qrcode_yape' => $this->qrcode_yape,
            'name_yape' => $this->name_yape,
            'telephone_yape' => $this->telephone_yape,
            'image_url_yape' => $this->image_url_yape,
            'enabled_mp' => $this->enabled_mp,
            'public_key_mp' => $this->public_key_mp,
        ];
    }


    public static function getPublicRowResource()
    {

        $record = PaymentConfiguration::first();

        return [
            'name_yape' => $record->name_yape,
            'telephone_yape' => $record->telephone_yape,
            'image_url_yape' => $record->image_url_yape,
        ];

    }

    public static function getPaymentPermissions()
    {

        $record = PaymentConfiguration::select('enabled_yape', 'enabled_mp')->firstOrFail();

        return [
            'enabled_yape' => $record->enabled_yape,
            'enabled_mp' => $record->enabled_mp,
        ];

    }


}