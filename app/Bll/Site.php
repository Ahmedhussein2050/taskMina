<?php

namespace App\Bll;

use App\Setting;
use App\Models\Blog\BlogCategory;
use App\Modules\Portal\Models\SitePage;
use App\Modules\Admin\Models\Pages\SubPages;
use App\Modules\Portal\Models\ContentSection;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Sections\Sections;
use App\Modules\Admin\Models\Services\Services;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Services\ServicesData;
use Illuminate\Support\Facades\Cache;

class Site
{

    public static function getSettings()
    {
        $setting = Cache::get('setting');
        if ($setting != null) {
            return $setting;
        } else {
            $setting = Setting::join('settings_data', 'settings.id', 'settings_data.setting_id')
                ->select(
                    'settings_data.id',
                    'settings_data.title',
                    'settings.id as setting_id',
                    'settings_data.lang_id',
                    'settings.logo',
                    'settings.email',
                    'settings.address',
                    'settings.facebook_url',
                    'settings.twitter_url',
                    'settings.youtube_url',
                    'settings.instagram_url',
                    'settings.phone1',
                    'settings.phone2',
                    'settings_data.description',

                )
                ->where('settings_data.lang_id', Lang::getSelectedLangId())
                ->first();
            Cache::forever('setting', $setting);
        }

        return $setting;
    }
}
