<?php

namespace App\Services;

use App\Models\OwnerDocument;
use App\Models\User;

class OwnerDocumentService
{
    public function store(User $user, array $data): OwnerDocument
    {
        return OwnerDocument::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'national_id'       => $data['national_id'],
                'issue_city_id'     => $data['issue_city_id'],
                'issue_date'        => $data['issue_date'],
                'expiry_date'       => $data['expiry_date'],
                'id_card_image_url' => $data['id_card_image_url'],
            ]
        );
    }
}