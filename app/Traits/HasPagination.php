<?php

namespace App\Traits;

trait HasPagination
{
    private function pagination(&$data, &$page) : array {
        $page['has_next'] = false;
        if ($data->nextPageUrl() != null) {
            $page['next_page'] = $data->currentPage() + 1;
            $page['has_next'] = true;
        }
        return $page;
    }
}
