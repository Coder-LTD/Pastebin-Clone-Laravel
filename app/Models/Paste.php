<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Paste extends Model
{
    /** @use HasFactory<\Database\Factories\PasteFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'language',
        'expiry_type',
        'visibility',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_burned' => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    // =========================================================================
    // Boot
    // =========================================================================

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Paste $paste) {
            if (empty($paste->slug)) {
                $paste->slug = self::generateSlug();
            }

            if (empty($paste->expires_at)) {
                $paste->expires_at = $paste->getExpiryDate();
            }
        });
    }

    // =========================================================================
    // Mutators
    // =========================================================================

    /**
     * Auto-hash the password attribute when set.
     */
    protected function setPasswordAttribute(?string $value): void
    {
        $this->attributes['password'] = $value ? Hash::make($value) : null;
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    /**
     * Scope: only publicly visible, not burned, and not expired pastes.
     */
    public function scopePublic(\Illuminate\Database\Eloquent\Builder $query): void
    {
        $query->where('visibility', 'public')
            ->where('is_burned', false)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope: only pastes that haven't expired or been burned.
     */
    public function scopeNotExpired(\Illuminate\Database\Eloquent\Builder $query): void
    {
        $query->where('is_burned', false)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope: find a paste by its slug.
     */
    public function scopeBySlug(\Illuminate\Database\Eloquent\Builder $query, string $slug): void
    {
        $query->where('slug', $slug);
    }

    // =========================================================================
    // Methods
    // =========================================================================

    /**
     * Check if the paste has expired.
     */
    public function isExpired(): bool
    {
        if ((bool) $this->is_burned) {
            return true;
        }

        if ($this->expires_at === null) {
            return false;
        }

        return $this->expires_at->isPast();
    }

    /**
     * Check if the paste is password protected.
     */
    public function isPasswordProtected(): bool
    {
        return $this->password !== null;
    }

    /**
     * Check if a burn-after-read paste has been burned.
     */
    public function hasBurned(): bool
    {
        return (bool) $this->is_burned;
    }

    /**
     * Compute the expiry date based on expiry_type and created_at.
     */
    public function getExpiryDate(): ?Carbon
    {
        $base = $this->created_at ?? now();

        return match ($this->expiry_type) {
            'burn_after_read' => null,
            '1_hour' => $base->copy()->addHour(),
            '1_day' => $base->copy()->addDay(),
            '1_week' => $base->copy()->addWeek(),
            'never' => null,
            default => null,
        };
    }

    /**
     * Generate a unique 8-character random slug.
     */
    public static function generateSlug(): string
    {
        do {
            $slug = Str::random(8);
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }

    /**
     * Increment the views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    /**
     * Mark the paste as burned (for burn-after-read).
     */
    public function burn(): void
    {
        $this->forceFill(['is_burned' => true])->save();
    }
}
