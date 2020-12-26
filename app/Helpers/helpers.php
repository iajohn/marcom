<?php

use App\Models\User;
// use App\Models\Setting;
// use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
// use App\Repositories\NotificationRepository;

/**
 * @return int
 */
function getLoggedInUserId()
{
    return Auth::id();
}

/**
 * @return User
 */
function getLoggedInUser()
{
    return Auth::user();
}

// function detectURL($url)
// {
//     if (strpos($url, 'youtube.com/watch?v=') > 0) {
//         return Conversation::YOUTUBE_URL;
//     }
//     return 0;
// }

function isValidURL($url)
{
    return filter_var($url, FILTER_VALIDATE_URL);
}

// function getDefaultAvatar() {
//     return asset('assets/images/avatar.png');
// }

/**
 * return random color.
 *
 * @param  int  $userId
 *
 * @return string
 */
function getRandomColor($userId)
{
    $colors = ['329af0', 'fc6369', 'ffaa2e', '42c9af', '7d68f0'];
    $index = $userId % 5;

    return $colors[$index];
}

/**
 * return avatar url.
 *
 * @return string
 */
function getAvatarUrl()
{
    return 'https://ui-avatars.com/api/';
}

/**
 * return avatar full url.
 *
 * @param  int  $userId
 * @param  string  $name
 *
 * @return string
 */
function getUserImageInitial($userId, $name)
{
    return getAvatarUrl()."?name=$name&size=100&rounded=true&color=fff&background=".getRandomColor($userId);
}

/**
 * @return array
 */
// function getNotifications()
// {
//     /** @var NotificationRepository $notificationRepo */
//     $notificationRepo = app(NotificationRepository::class);

//     return $notificationRepo->getNotifications();
// }

/**
 * @return mixed|string
 */
// function getAppName()
// {
//     $appNameSetting = Setting::where('key', '=', 'app_name')->first();
//     if (! empty($appNameSetting)) {
//         return $appNameSetting->value;
//     }

//     return config('app.name');
// }

/**
 * @return mixed|string
 */
// function getCompanyName()
// {
//     $appNameSetting = Setting::where('key', '=', 'company_name')->first();
//     if (! empty($appNameSetting)) {
//         return $appNameSetting->value;
//     }

//     return config('app.name');
// }

/**
 * @return string
 */
// function getLogoUrl()
// {
//     $setting = Setting::where('key', '=', 'logo_url')->first();
//     if (! empty($setting) && ! empty($setting->value)) {
//         return app(Setting::class)->getLogoUrl($setting->value);
//     }

//     return asset('assets/images/logo.png');
// }

/**
 * @return string
 */
// function getThumbLogoUrl()
// {
//     $setting = Setting::where('key', '=', 'logo_url')->first();
//     if (! empty($setting) && ! empty($setting->value)) {
//         return app(Setting::class)->getLogoUrl($setting->value, Setting::THUMB_PATH);
//     }

//     return asset('assets/images/logo-30x30.png');
// }

/**
 * @return string
 */
// function getFaviconUrl()
// {
//     $setting = Setting::where('key', '=', 'favicon_url')->first();
//     if (! empty($setting) && ! empty($setting->value)) {
//         return asset($setting->value);
//     }

//     return asset('assets/images/favicon/favicon-16x16.ico');
// }

/**
 * @return int|mixed
 */
// function isGroupChatEnabled()
// {
//     $setting = Setting::where('key', '=', 'enable_group_chat')->first();
//     if (! empty($setting)) {
//         return $setting->value;
//     }

//     return true;
// }
