<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $action, string $module, ?string $description = null, array $properties = []): void
    {
        $request = request();

        self::create([
            'user_id'     => $request?->user()?->id,
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'properties'  => $properties,
            'ip_address'  => $request?->ip(),
            'user_agent'  => $request?->userAgent(),
        ]);
    }
}
