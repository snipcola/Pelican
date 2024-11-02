<?php

namespace App\Http\ViewComposers;

use App\Services\Helpers\AssetHashService;
use Illuminate\View\View;

class AssetComposer
{
    /**
     * AssetComposer constructor.
     */
    public function __construct(private AssetHashService $assetHashService)
    {
    }

    /**
     * Provide access to the asset service in the views.
     */
    public function compose(View $view): void
    {
        $view->with('asset', $this->assetHashService);
        $view->with('siteConfiguration', [
            'name' => config('app.name', 'Panel'),
            'locale' => config('app.locale') ?? 'en',
            'recaptcha' => [
                'enabled' => config('turnstile.turnstile_enabled', false),
                'siteKey' => config('turnstile.turnstile_site_key') ?? '',
            ],
            'usesSyncDriver' => config('queue.default') === 'sync',
            'serverDescriptionsEditable' => config('panel.editable_server_descriptions'),
        ]);
    }
}
