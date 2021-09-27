<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Jaybizzle\LaravelCrawlerDetect\Facades\LaravelCrawlerDetect as Crawler;
use App\Models\Activity;
use function strtolower;

trait ActivityLogger
{

    public static function activity($description = null)
    {
        $userType = trans('laravel-logger.userTypes.guest');
        $userId   = null;

        if (Auth::check())
        {
            $userType = trans('laravel-logger.userTypes.registered');
            $userIdField = config('laravel-logger.defaultUserIDField');
            $userId = Request::user()->{$userIdField};
        }

        if(Crawler::isCrawler())
        {
            $userType = trans('laravel-logger.userTypes.crawler');
            if(is_null($description)) $description = $userType.' '.trans('laravel-logger.verbTypes.crawled').' '.Request::fullUrl();
        }

        if(!$description)
        {
            switch (strtolower(Request::method()))
            {
                case 'post':
                    $verb = __('laravel-logger.verbTypes.created');
                    break;

                case 'patch':
                case 'put':
                    $verb = __('laravel-logger.verbTypes.edited');
                    break;

                case 'delete':
                    $verb = __('laravel-logger.verbTypes.deleted');
                    break;

                case 'get':
                    $verb = __('laravel-logger.verbTypes.viewed');
                    break;
            }

            $description = $verb.' '.Request::path();
        }

        $data = [
            'description'   => $description,
            'userType'      => $userType,
            'userId'        => $userId,
            'route'         => Request::fullUrl(),
            'ipAddress'     => Request::ip(),
            'userAgent'     => Request::header('user-agent'),
            'locale'        => Request::header('accept-language'),
            'referer'       => Request::header('referer'),
            'methodType'    => Request::method(),
        ];

        $validator = Validator::make($data, Activity::rules());
        if($validator->fails())
        {
            $errors = self::prepareErrorMessage($validator->errors(), $data);
            if(config('laravel-logger.logDBActivityLogFailuresToFile'))
            {
                Log:error('Failed to record activity event. Failed validation: '.$errors);
            }
        } else {
            self::storeActivity($data);
        }
    }

    private static function storeActivity($data)
    {
        Activity::create([
                             'description'   => $data['description'],
                             'userType'      => $data['userType'],
                             'userId'        => $data['userId'],
                             'route'         => $data['route'],
                             'ipAddress'     => $data['ipAddress'],
                             'userAgent'     => $data['userAgent'],
                             'locale'        => $data['locale'],
                             'referer'       => $data['referer'],
                             'methodType'    => $data['methodType'],
                         ]);
    }

    private static function prepareErrorMessage($validatorErrors, $data)
    {
        $errors = json_decode(json_encode($validatorErrors, true));
        array_walk($errors, function (&$value, $key) use ($data) {
            array_push($value, "Value: $data[$key]");
        });

        return json_encode($errors, true);
    }

}
