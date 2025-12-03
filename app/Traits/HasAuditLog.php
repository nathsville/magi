<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait HasAuditLog
{
    public static function bootHasAuditLog()
    {
        // Log saat create
        static::created(function ($model) {
            self::logActivity('CREATE', $model);
        });

        // Log saat update
        static::updated(function ($model) {
            self::logActivity('UPDATE', $model);
        });

        // Log saat delete
        static::deleted(function ($model) {
            self::logActivity('DELETE', $model);
        });
    }

    protected static function logActivity($action, $model)
    {
        $user = Auth::user();
        
        $oldValues = null;
        $newValues = null;

        if ($action === 'UPDATE') {
            $oldValues = $model->getOriginal();
            $newValues = $model->getAttributes();
        } elseif ($action === 'CREATE') {
            $newValues = $model->getAttributes();
        } elseif ($action === 'DELETE') {
            $oldValues = $model->getAttributes();
        }

        AuditLog::create([
            'id_user' => $user?->id_user,
            'action' => $action,
            'module' => class_basename($model),
            'record_id' => $model->getKey(),
            'description' => self::generateDescription($action, $model),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    protected static function generateDescription($action, $model)
    {
        $modelName = class_basename($model);
        $identifier = method_exists($model, 'getIdentifier') 
            ? $model->getIdentifier() 
            : ($model->name ?? $model->nama ?? $model->getKey());

        return match($action) {
            'CREATE' => "Membuat {$modelName} baru: {$identifier}",
            'UPDATE' => "Memperbarui {$modelName}: {$identifier}",
            'DELETE' => "Menghapus {$modelName}: {$identifier}",
            default => "{$action} {$modelName}: {$identifier}"
        };
    }
}