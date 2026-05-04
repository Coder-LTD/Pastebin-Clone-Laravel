<?php

namespace Database\Seeders;

use App\Models\Paste;
use Illuminate\Database\Seeder;

class PasteSeeder extends Seeder
{
    /**
     * Languages to cycle through.
     */
    private const LANGUAGES = [
        'php',
        'javascript',
        'python',
        'html',
        'css',
        'json',
        'plaintext',
        'sql',
        'bash',
        'yaml',
    ];

    /**
     * Expiry types for variety.
     */
    private const EXPIRY_TYPES = [
        'burn_after_read',
        '1_hour',
        '1_day',
        '1_week',
        'never',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── 10 public PHP pastes ──────────────────────────────────────────
        Paste::factory()
            ->count(10)
            ->public()
            ->sequence(fn ($sequence) => ['language' => 'php'])
            ->create();

        // ── 10 public JavaScript pastes ────────────────────────────────────
        Paste::factory()
            ->count(10)
            ->public()
            ->sequence(fn ($sequence) => ['language' => 'javascript'])
            ->create();

        // ── 10 public Python pastes ────────────────────────────────────────
        Paste::factory()
            ->count(10)
            ->public()
            ->sequence(fn ($sequence) => ['language' => 'python'])
            ->create();

        // ── 5 public HTML pastes ───────────────────────────────────────────
        Paste::factory()
            ->count(5)
            ->public()
            ->sequence(fn ($sequence) => ['language' => 'html'])
            ->create();

        // ── 5 public CSS pastes ────────────────────────────────────────────
        Paste::factory()
            ->count(5)
            ->public()
            ->sequence(fn ($sequence) => ['language' => 'css'])
            ->create();

        // ── 5 public JSON pastes ───────────────────────────────────────────
        Paste::factory()
            ->count(5)
            ->public()
            ->sequence(fn ($sequence) => ['language' => 'json'])
            ->create();

        // ── 5 public plaintext pastes ──────────────────────────────────────
        Paste::factory()
            ->count(5)
            ->public()
            ->sequence(fn ($sequence) => ['language' => 'plaintext'])
            ->create();
    }
}
