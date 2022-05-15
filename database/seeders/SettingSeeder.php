<?php

namespace Database\Seeders;

use App\Enums\SmtpStatus;
use Illuminate\Database\Seeder;
use Setting as SettingInsert;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settingArray['site_name']          = 'Sheaearn';
        $settingArray['site_email']         = 'info@sheaearn.com';
        $settingArray['site_phone_number']  = '+12055759342';
        $settingArray['site_currency_name'] = 'NGN';
        $settingArray['site_currency_code'] = '₦';
        $settingArray['site_timezone']      = 'Africa/Lagos';
        $settingArray['site_footer']        = '@ All Rights Reserved';
        $settingArray['site_logo']          = 'logo.png';
        $settingArray['site_logo_white']    = 'logo-white.png';
        $settingArray['site_favicon']       = 'logo.png';
        $settingArray['site_description']   = 'Sheaearn is an online store platform in Nigeria.';

        $settingArray['mail_host']         = '';
        $settingArray['mail_port']         = '';
        $settingArray['mail_username']     = '';
        $settingArray['mail_password']     = '';
        $settingArray['mail_from_name']    = '';
        $settingArray['mail_from_address'] = '';
        $settingArray['mail_disabled']     = SmtpStatus::INACTIVE;

        $settingArray['social_facebook']  = '';
        $settingArray['social_twitter']   = '';
        $settingArray['social_youtube']   = '';
        $settingArray['social_instagram'] = '';

        $settingArray['paystack_active']   = 1;
        $settingArray['paystack_key']  = 'pk_test_f389d8248d55b4b99cf0aa200c16b588536bcfbc';
        $settingArray['paystack_secret']   = 'sk_test_bda89d2e1dd04ac8c97046990e064266e84c20f9';

        $settingArray['referral_bonus'] = 10;
        $settingArray['affiliate_fee'] = 1000;
        $settingArray['order_commission'] = 0.5;
        $settingArray['intra_state_shipping_fee'] = 1000;
        $settingArray['inter_state_shipping_fee'] = 2000;
        $settingArray['order_method'] = 'cart';

        SettingInsert::set($settingArray);
        SettingInsert::save();

    }
}
