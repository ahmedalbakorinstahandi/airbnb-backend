<?php

namespace App\Http\Permissions;

use App\Models\User;
use App\Services\MessageService;
use Illuminate\Support\Facades\Auth;

class ListingPermission
{
    public static function filterIndex($query)
    {

        $is_guest = false;

        $user = User::auth();
        if ($user) {


            if ($user->isHost()) {
                $query->where('host_id', $user->id);
            } elseif ($user->isGuest()) {
                $is_guest = true;
            }
        } else {
            $is_guest = true;
        }

        if ($is_guest) {
            $query->where('status', 'approved')->where('is_published', true);
        }

        return $query;
    }

    public static function canShow($listing)
    {


       

        return false;
    }

    public static function create($data)
    {
        $user = User::auth();

        $host_id = null;

        if ($user->isHost()) {
            $host_id = $user->id;
        } else {
            $host_id = $data['host_id'];
        }

        $host = User::find($host_id);

        $data['host_id'] = $host_id;

      //  if (!$host || !$host->isHost()) {
        //    MessageService::abort(403, 'messages.host.not_found');
       // }

        return $data;
    }

    public static function canUpdate($listing)
    {
        $user = User::auth();

        if ($user->isHost()) {
            if ($listing->host_id != $user->id) {
                MessageService::abort(403, 'messages.permission.error');
            }
        }

        return false;
    }

    public static function canDelete($listing)
    {
        $user = User::auth();

        if ($user->isHost()) {
            if ($listing->host_id != $user->id) {
                MessageService::abort(403, 'messages.permission.error');
            }
        }

        return false;
    }
}
