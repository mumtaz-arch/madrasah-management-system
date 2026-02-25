<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            ActivityLog::log(
                'created',
                class_basename($model) . ' baru dibuat',
                $model,
                null,
                $model->getAttributes()
            );
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            unset($changes['updated_at']);
            
            if (!empty($changes)) {
                ActivityLog::log(
                    'updated',
                    class_basename($model) . ' diperbarui',
                    $model,
                    $model->getOriginal(),
                    $changes
                );
            }
        });

        static::deleted(function ($model) {
            ActivityLog::log(
                'deleted',
                class_basename($model) . ' dihapus',
                $model,
                $model->getAttributes(),
                null
            );
        });
    }
}
