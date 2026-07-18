<?php
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogService
{
    public static function log(
        string $action,
        string $description,
        $subject = null,
        array $oldValues = null,
        array $newValues = null
    ): ActivityLog {
        $request = request();

        return ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    public static function created($subject, array $newValues = null): ActivityLog
    {
        $name = class_basename(get_class($subject));
        return self::log(
            'created',
            "Created {$name}: " . self::getDisplayName($subject),
            $subject,
            null,
            $newValues ?? $subject->toArray()
        );
    }

    public static function updated($subject, array $oldValues, array $newValues): ActivityLog
    {
        $name = class_basename(get_class($subject));
        return self::log(
            'updated',
            "Updated {$name}: " . self::getDisplayName($subject),
            $subject,
            $oldValues,
            $newValues
        );
    }

    public static function deleted($subject): ActivityLog
    {
        $name = class_basename(get_class($subject));
        return self::log(
            'deleted',
            "Deleted {$name}: " . self::getDisplayName($subject),
            $subject,
            $subject->toArray()
        );
    }

    public static function viewed(string $description): ActivityLog
    {
        return self::log('viewed', $description);
    }

    public static function login(): ActivityLog
    {
        return self::log('logged_in', 'User logged in');
    }

    private static function getDisplayName($subject): string
    {
        if (method_exists($subject, 'getAttribute')) {
            if ($subject->getAttribute('first_name')) {
                return trim($subject->getAttribute('first_name') . ' ' . $subject->getAttribute('last_name'));
            }
            if ($subject->getAttribute('class_name')) {
                return $subject->getAttribute('class_name');
            }
            if ($subject->getAttribute('name')) {
                return $subject->getAttribute('name');
            }
            if ($subject->getAttribute('exam_name')) {
                return $subject->getAttribute('exam_name');
            }
            if ($subject->getAttribute('fee_type')) {
                return $subject->getAttribute('fee_type');
            }
        }
        return '#' . $subject->getKey();
    }
}
