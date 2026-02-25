<?php

namespace App\Enums;

/**
 * User role enum for strict type-safe role management.
 * Used throughout the system for authorization and routing.
 */
enum RoleEnum: string
{
    case Admin = 'admin';
    case Operator = 'operator';
    case Guru = 'guru';
    case Santri = 'santri';
    case Wali = 'wali';

    /**
     * Get the display label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Operator => 'Operator',
            self::Guru => 'Guru',
            self::Santri => 'Santri',
            self::Wali => 'Wali Santri',
        };
    }

    /**
     * Check if this role has admin-level access.
     */
    public function isAdminLevel(): bool
    {
        return in_array($this, [self::Admin, self::Operator]);
    }

    /**
     * Get the dashboard route for this role.
     */
    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Admin, self::Operator => 'admin.dashboard',
            self::Guru => 'guru.dashboard',
            self::Santri => 'santri.dashboard',
            self::Wali => 'wali.dashboard',
        };
    }

    /**
     * Get all roles as an array (for validation rules, etc.)
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
