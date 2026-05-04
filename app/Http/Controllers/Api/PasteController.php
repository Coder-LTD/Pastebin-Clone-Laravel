<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PasteResource;
use App\Models\Paste;
use App\Services\PasteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class PasteController extends Controller
{
    /**
     * Map form expiry values to model expiry_type values.
     *
     * @var array<string, string>
     */
    protected array $expiryMap = [
        'burn' => 'burn_after_read',
        '1h'   => '1_hour',
        '1d'   => '1_day',
        '1w'   => '1_week',
        'never' => 'never',
    ];

    public function __construct(
        protected PasteService $pasteService
    ) {}

    /**
     * GET /api/v1/pastes
     *
     * Returns paginated public pastes with optional language filter.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min((int) $request->input('per_page', 20), 100);
        $language = $request->input('language');

        $query = Paste::public()->notExpired()->orderByDesc('created_at');

        if ($language) {
            $query->where('language', $language);
        }

        return PasteResource::collection($query->paginate($perPage));
    }

    /**
     * POST /api/v1/pastes
     *
     * Create a new paste and return it as JSON with 201 status.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'      => ['nullable', 'string', 'max:255'],
            'content'    => ['required', 'string', 'min:1', 'max:500000'],
            'language'   => ['required', 'string', 'in:plaintext,php,javascript,typescript,python,ruby,java,csharp,cpp,go,rust,html,css,json,yaml,sql,bash'],
            'expires_at' => ['required', 'string', 'in:burn,1h,1d,1w,never'],
            'visibility' => ['required', 'string', 'in:public,private,unlisted'],
            'password'   => ['nullable', 'string', 'min:3', 'max:255'],
        ]);

        // Map expires_at form value to expiry_type model value
        $validated['expiry_type'] = $this->expiryMap[$validated['expires_at']];
        unset($validated['expires_at']);

        $paste = $this->pasteService->create($validated);
        $paste->refresh();

        return (new PasteResource($paste))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * GET /api/v1/pastes/{slug}
     *
     * Return a single paste as JSON. Increments views, handles burn-after-read.
     */
    public function show(string $slug): JsonResponse|PasteResource
    {
        $paste = Paste::bySlug($slug)->first();

        if (! $paste) {
            return response()->json([
                'message' => 'Paste not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        // Return 410 if already burned
        if ($paste->hasBurned()) {
            return response()->json([
                'message' => 'This paste has been burned after reading.',
            ], Response::HTTP_GONE);
        }

        // Return 410 if expired
        if ($paste->isExpired()) {
            return response()->json([
                'message' => 'This paste has expired.',
            ], Response::HTTP_GONE);
        }

        // Increment view count
        $paste->incrementViews();

        // If burn_after_read, mark as burned (one-time view)
        if ($paste->expiry_type === 'burn_after_read') {
            $paste->burn();
        }

        // Refresh to get updated views_count and is_burned
        $paste->refresh();

        return new PasteResource($paste);
    }
}
