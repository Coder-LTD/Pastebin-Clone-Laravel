<?php

namespace Database\Factories;

use App\Models\Paste;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paste>
 */
class PasteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Paste::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $languages = ['php', 'javascript', 'python', 'html', 'css', 'json', 'plaintext', 'sql', 'bash', 'yaml'];
        $expiryTypes = ['burn_after_read', '1_hour', '1_day', '1_week', 'never'];
        $visibilities = ['public', 'private', 'unlisted'];

        return [
            'slug' => Paste::generateSlug(),
            'title' => $this->faker->optional(0.8)->sentence(rand(1, 6)),
            'content' => $this->generateContent(),
            'language' => $this->faker->randomElement($languages),
            'expiry_type' => $this->faker->randomElement($expiryTypes),
            'visibility' => $this->faker->randomElement($visibilities),
            'password' => null,
            'is_burned' => false,
            'views_count' => $this->faker->numberBetween(0, 5000),
        ];
    }

    /**
     * Generate realistic code/content for the given language.
     */
    protected function generateContent(): string
    {
        $samples = [
            'php' => "<?php\n\nnamespace App\Services;\n\nclass Calculator\n{\n    public function add(int \$a, int \$b): int\n    {\n        return \$a + \$b;\n    }\n\n    public function multiply(int \$a, int \$b): int\n    {\n        return \$a * \$b;\n    }\n}\n",
            'javascript' => "function fibonacci(n) {\n    if (n <= 1) return n;\n    \n    let prev = 0, curr = 1;\n    \n    for (let i = 2; i <= n; i++) {\n        [prev, curr] = [curr, prev + curr];\n    }\n    \n    return curr;\n}\n\nconsole.log(fibonacci(10)); // 55\n",
            'python' => "def quicksort(arr):\n    if len(arr) <= 1:\n        return arr\n    \n    pivot = arr[len(arr) // 2]\n    left = [x for x in arr if x < pivot]\n    middle = [x for x in arr if x == pivot]\n    right = [x for x in arr if x > pivot]\n    \n    return quicksort(left) + middle + quicksort(right)\n\nprint(quicksort([3, 6, 8, 10, 1, 2, 1]))\n",
            'html' => "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <title>Hello World</title>\n</head>\n<body>\n    <h1>Welcome to Pastebin!</h1>\n    <p>Share your code snippets easily.</p>\n</body>\n</html>\n",
            'css' => ".container {\n    max-width: 1200px;\n    margin: 0 auto;\n    padding: 2rem;\n}\n\n.btn {\n    display: inline-block;\n    padding: 0.75rem 1.5rem;\n    border-radius: 0.5rem;\n    font-weight: 600;\n    transition: all 0.2s ease;\n}\n\n.btn-primary {\n    background-color: #3b82f6;\n    color: white;\n}\n\n.btn-primary:hover {\n    background-color: #2563eb;\n}\n",
            'json' => "{\n    \"name\": \"pastebin-clone\",\n    \"version\": \"1.0.0\",\n    \"description\": \"A simple pastebin clone built with Laravel\",\n    \"scripts\": {\n        \"dev\": \"vite\",\n        \"build\": \"vite build\"\n    },\n    \"dependencies\": {\n        \"tailwindcss\": \"^3.4.0\",\n        \"axios\": \"^1.7.0\"\n    }\n}\n",
            'sql' => "-- Create users table\nCREATE TABLE users (\n    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,\n    name VARCHAR(255) NOT NULL,\n    email VARCHAR(255) UNIQUE NOT NULL,\n    password VARCHAR(255) NOT NULL,\n    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\n);\n\n-- Insert sample data\nINSERT INTO users (name, email, password) VALUES\n    ('Alice', 'alice@example.com', 'hashed_password_1'),\n    ('Bob', 'bob@example.com', 'hashed_password_2');\n",
            'bash' => "#!/bin/bash\n\n# Deploy script\nset -euo pipefail\n\necho \"Starting deployment...\"\n\n# Pull latest changes\ngit pull origin main\n\n# Install dependencies\ncomposer install --no-dev --optimize-autoloader\nnpm ci && npm run build\n\n# Run migrations\nphp artisan migrate --force\n\n# Clear cache\nphp artisan optimize\n\necho \"Deployment complete!\"\n",
            'yaml' => "# Docker Compose configuration\nversion: '3.8'\n\nservices:\n  app:\n    build: .\n    volumes:\n      - .:/var/www/html\n    environment:\n      - APP_ENV=local\n      - DB_HOST=db\n\n  nginx:\n    image: nginx:alpine\n    ports:\n      - '8080:80'\n    depends_on:\n      - app\n\n  db:\n    image: mysql:8.0\n    environment:\n      MYSQL_ROOT_PASSWORD: secret\n      MYSQL_DATABASE: pastebin\n",
            'plaintext' => "Meeting Notes — 2024-03-15\n============================\n\nAttendees: Alice, Bob, Charlie\n\nAgenda:\n1. Review Q1 milestones\n2. Plan Q2 roadmap\n3. Assign action items\n\nDecision: We'll migrate the backend to Laravel 11 by end of April.\n\nAction Items:\n- Alice: Set up new Laravel project scaffold (due: March 20)\n- Bob: Write migration for pastes table (due: March 22)\n- Charlie: Build frontend with Tailwind (due: March 28)\n",
        ];

        return $this->faker->randomElement($samples);
    }

    // =========================================================================
    // States
    // =========================================================================

    /**
     * Indicate that the paste is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => 'public',
        ]);
    }

    /**
     * Indicate that the paste is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => 'private',
        ]);
    }

    /**
     * Indicate that the paste is unlisted.
     */
    public function unlisted(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility' => 'unlisted',
        ]);
    }

    /**
     * Indicate that the paste never expires.
     */
    public function neverExpires(): static
    {
        return $this->state(fn (array $attributes) => [
            'expiry_type' => 'never',
        ]);
    }

    /**
     * Indicate that the paste is burn-after-read.
     */
    public function burnAfterRead(): static
    {
        return $this->state(fn (array $attributes) => [
            'expiry_type' => 'burn_after_read',
        ]);
    }

    /**
     * Indicate that the paste is password protected.
     */
    public function passwordProtected(string $password = 'secret123'): static
    {
        return $this->state(fn (array $attributes) => [
            'password' => $password,
        ]);
    }
}
