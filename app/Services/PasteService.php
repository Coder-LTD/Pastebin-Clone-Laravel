<?php

namespace App\Services;

use App\Models\Paste;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PasteService
{
    /**
     * Create a new paste from validated data.
     */
    public function create(array $data): Paste
    {
        return Paste::create($data);
    }

    /**
     * Find a paste by its slug or abort with 404.
     */
    public function findBySlug(string $slug): Paste
    {
        $paste = Paste::bySlug($slug)->first();

        if (! $paste) {
            throw new HttpResponseException(
                response()->view('pastes.expired', [], 404)
            );
        }

        return $paste;
    }

    /**
     * Get paginated list of public, non-expired pastes.
     */
    public function getPublicPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return Paste::public()->notExpired()->orderByDesc('created_at')->paginate($perPage);
    }

    /**
     * Verify a password against a paste's stored hash.
     */
    public function verifyPassword(Paste $paste, ?string $password): bool
    {
        if (! $paste->isPasswordProtected()) {
            return true;
        }

        if ($password === null || $password === '') {
            return false;
        }

        return \Illuminate\Support\Facades\Hash::check($password, $paste->password);
    }
}
