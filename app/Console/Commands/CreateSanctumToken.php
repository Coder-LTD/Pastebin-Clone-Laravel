<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateSanctumToken extends Command
{
    protected $signature = 'sanctum:create-token
                            {email : The user email to create a token for}
                            {--name=api-token : The token name}';

    protected $description = 'Create a personal access token for a user';

    public function handle(): int
    {
        $email = $this->argument('email');
        $name = $this->option('name');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("No user found with email: {$email}");
            return self::FAILURE;
        }

        $token = $user->createToken($name);

        $this->info('Token created successfully!');
        $this->newLine();
        $this->line("  <fg=gray>User:</> {$user->name} ({$user->email})");
        $this->line("  <fg=gray>Token name:</> {$name}");
        $this->line("  <fg=gray>Plain text token:</> <fg=yellow>{$token->plainTextToken}</>");
        $this->newLine();
        $this->warn('Store this token securely. It will not be shown again.');

        return self::SUCCESS;
    }
}
