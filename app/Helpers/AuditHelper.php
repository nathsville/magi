<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditHelper
{
    public static function log($action, $module, $description, $recordId = null, $oldValues = null, $newValues = null)
    {
        AuditLog::create([
            'id_user' => Auth::id(),
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function logLogin($user)
    {
        self::log(
            'LOGIN',
            'Auth',
            "Login berhasil: {$user->nama} ({$user->username})",
            $user->id_user
        );
    }

    public static function logLogout($user)
    {
        self::log(
            'LOGOUT',
            'Auth',
            "Logout: {$user->nama} ({$user->username})",
            $user->id_user
        );
    }

    public static function logBroadcast($target, $channel, $recipientCount)
    {
        self::log(
            'CREATE',
            'Broadcast',
            "Mengirim broadcast ke {$recipientCount} penerima via {$channel} (Target: {$target})"
        );
    }

    public static function logValidation($type, $recordId, $status)
    {
        self::log(
            'UPDATE',
            'Validasi',
            "Validasi data {$type} dengan status: {$status}",
            $recordId
        );
    }
}