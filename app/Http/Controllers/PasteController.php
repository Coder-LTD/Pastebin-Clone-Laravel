<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Services\PasteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PasteController extends Controller
{
    /**
     * Map form expiry values to model expiry_type values.
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
     * Display a paginated list of public pastes.
     */
    public function index(): View
    {
        $pastes = $this->pasteService->getPublicPaginated(20);

        return view('pastes.index', compact('pastes'));
    }

    /**
     * Show the paste creation form.
     */
    public function create(): View
    {
        return view('pastes.create');
    }

    /**
     * Store a newly created paste.
     */
    public function store(Request $request): RedirectResponse
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

        return redirect()
            ->route('pastes.show', $paste->slug)
            ->with('success', 'Paste created successfully!');
    }

    /**
     * Display the specified paste.
     */
    public function show(string $slug): View|Response
    {
        $paste = $this->pasteService->findBySlug($slug);

        // Step 2: If burn_after_read and already burned → 410
        if ($paste->hasBurned()) {
            return response()->view('pastes.expired', ['paste' => $paste], 410);
        }

        // Step 3: If expires_at is in the past → 410
        if ($paste->isExpired()) {
            return response()->view('pastes.expired', ['paste' => $paste], 410);
        }

        // Step 5: Increment view count
        $paste->incrementViews();

        // Step 6: If burn_after_read, mark as burned (one-time view)
        if ($paste->expiry_type === 'burn_after_read') {
            $paste->burn();
        }

        return view('pastes.show', compact('paste'));
    }

    /**
     * Display the raw paste content as plain text.
     */
    public function raw(string $slug): Response
    {
        $paste = $this->pasteService->findBySlug($slug);

        if ($paste->hasBurned() || $paste->isExpired()) {
            return response('This paste has expired.', 410)
                ->header('Content-Type', 'text/plain');
        }

        return response($paste->content, 200)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    /**
     * Show the password form for a protected paste.
     */
    public function passwordForm(string $slug): View
    {
        $paste = $this->pasteService->findBySlug($slug);

        return view('pastes.password', compact('paste'));
    }

    /**
     * Handle password submission for a protected paste.
     */
    public function passwordSubmit(string $slug, Request $request): RedirectResponse
    {
        $paste = $this->pasteService->findBySlug($slug);

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! $this->pasteService->verifyPassword($paste, $request->input('password'))) {
            return redirect()
                ->route('pastes.password', $paste->slug)
                ->with('error', 'Incorrect password. Please try again.');
        }

        // Store verified slug in session
        $verifiedPastes = session()->get('verified_pastes', []);
        $verifiedPastes[$paste->slug] = true;
        session()->put('verified_pastes', $verifiedPastes);

        return redirect()->route('pastes.show', $paste->slug);
    }
}
