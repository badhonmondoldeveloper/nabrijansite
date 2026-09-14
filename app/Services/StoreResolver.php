<?php

namespace App\Services;

use App\Models\Store;
use App\Models\StoreDomain;
use Exception;

class StoreResolver {
    private Store $storeModel;
    private StoreDomain $storeDomainModel;

    public function __construct() {
        $this->storeModel = new Store();
        $this->storeDomainModel = new StoreDomain();
    }

    /**
     * Resolve store tenant array from current HTTP context.
     */
    public function resolve(): ?array {
        try {
            $host = $_SERVER['HTTP_HOST'] ?? '';
            $mainDomain = config('app.domain', 'nabrijan.site');

            // Remove port if present
            if (str_contains($host, ':')) {
                $host = explode(':', $host)[0];
            }

            // 1. Subdomain Resolution (e.g. gadgetstore.nabrijan.site)
            if (str_contains($host, '.') && str_ends_with($host, $mainDomain) && $host !== $mainDomain) {
                $subdomain = str_replace('.' . $mainDomain, '', $host);
                if ($subdomain !== 'www' && $subdomain !== 'api' && $subdomain !== 'admin') {
                    return $this->storeModel->findBySlug($subdomain);
                }
            }

            // 2. Custom Domain Resolution (e.g. mygadgets.com)
            if ($host !== $mainDomain && $host !== 'localhost' && $host !== '127.0.0.1' && !str_ends_with($host, $mainDomain)) {
                $domainRecord = $this->storeDomainModel->findByDomain($host);
                if ($domainRecord) {
                    return $this->storeModel->find($domainRecord['store_id']);
                }
            }

            // 3. Path Fallback Resolution (e.g. nabrijan.site/store/gadgetstore)
            $uri = $_SERVER['REQUEST_URI'] ?? '';
            if (preg_match('#^/store/([a-zA-Z0-9_\-]+)#', $uri, $matches)) {
                return $this->storeModel->findBySlug($matches[1]);
            }
        } catch (Exception $e) {
            error_log("StoreResolver Error: " . $e->getMessage());
        }

        return null;
    }
}
