<?php

namespace App\Services;

use App\Enums\OwnerRequestStatus;
use App\Exceptions\BusinessException;
use App\Models\OwnerRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class OwnerRequestService
{
    public function createRequest(User $user, array $data): OwnerRequest
    {
        return DB::transaction(function () use ($user, $data) {

            /*
            |--------------------------------------------------------------------------
            | 1. User Already Owner
            |--------------------------------------------------------------------------
            */
            if ($user->hasRole('owner')) {
                throw new BusinessException(
                    __('owner_request.already_owner'),
                    422
                );
            }
            /*
            |--------------------------------------------------------------------------
            | 2. User must be renter
            |--------------------------------------------------------------------------
            */

            if (!$user->hasRole('renter')) 
            {
                throw new BusinessException(
                    __('owner_request.only_renter_can_apply'),
                    422
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 3. Prevent duplicate pending requests
            |--------------------------------------------------------------------------
            */

            $hasPendingRequest = OwnerRequest::query()
                ->where('user_id', $user->id)
                ->where('status',OwnerRequestStatus::PENDING)
                ->exists();


            if ($hasPendingRequest) {

                throw new BusinessException(
                    __('owner_request.pending_request_exists'),
                    422
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 4. Get Owner Documents
            |--------------------------------------------------------------------------
            */

            $ownerDocument = $user->ownerDocument;


            if (!$ownerDocument) {

                throw new BusinessException(
                    __('owner_request.owner_document_required'),
                    422
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 5. Validate required identity information
            |--------------------------------------------------------------------------
            */

            if (empty($ownerDocument->national_id) || empty($user->phone) || empty($user->name))
            {
                throw new BusinessException(
                    __('owner_request.incomplete_information'),
                    422
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 6. Create Owner Request
            |--------------------------------------------------------------------------
            */

            $ownerRequest = OwnerRequest::create([

                'user_id' => $user->id,

                'status' => OwnerRequestStatus::PENDING,

                /*
                | Snapshot
                */

                'full_name' => $user->name,

                'phone' => $user->phone,

                'national_id' => $ownerDocument->national_id,

                /*
                | Applicant notes
                */

                'notes' => $data['notes'] ?? null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | 7. Return Request
            |--------------------------------------------------------------------------
            */

            return $ownerRequest->load([
                'user',
            ]);
        });
    }

    public function approve(OwnerRequest $ownerRequest, User $admin): OwnerRequest
    {
        return DB::transaction(function () use ($ownerRequest, $admin)
        {

            /*
            |--------------------------------------------------------------------------
            | 1. Request must be pending
            |--------------------------------------------------------------------------
            */

            if ($ownerRequest->status!== OwnerRequestStatus::PENDING)
            {

                throw new BusinessException(
                    __('owner_request.already_reviewed'),
                    422
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 2. Applicant must still be renter
            |--------------------------------------------------------------------------
            */

            $user = $ownerRequest->user;

            if (!$user->hasRole('renter')) {

                throw new BusinessException(
                    __('owner_request.user_not_renter'),
                    422
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 3. Change role
            |--------------------------------------------------------------------------
            */

            $user->syncRoles(['owner']);


            /*
            |--------------------------------------------------------------------------
            | 4. Update request
            |--------------------------------------------------------------------------
            */

            $ownerRequest->update([

                'status' => OwnerRequestStatus::APPROVED,

                'reviewed_by' => $admin->id,

                'reviewed_at' => now(),

                'rejection_reason' => null,

            ]);


            /*
            |--------------------------------------------------------------------------
            | 5. Return updated request
            |--------------------------------------------------------------------------
            */

            return $ownerRequest->refresh();
        });
    }

    public function reject(OwnerRequest $ownerRequest, User $admin, string $reason): OwnerRequest 
    {
        return DB::transaction(function () use ($ownerRequest, $admin, $reason)
        {

            /*
            |--------------------------------------------------------------------------
            | 1. Request must be pending
            |--------------------------------------------------------------------------
            */

            if ($ownerRequest->status !== OwnerRequestStatus::PENDING) {

                throw new BusinessException(
                    __('owner_request.already_reviewed'),
                    422
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 2. Get Applicant
            |--------------------------------------------------------------------------
            */

            $user = $ownerRequest->user;


            /*
            |--------------------------------------------------------------------------
            | 3. Reject Request
            |--------------------------------------------------------------------------
            */

            $ownerRequest->update([

                'status' => OwnerRequestStatus::REJECTED,

                'reviewed_by' => $admin->id,

                'reviewed_at' => now(),

                'rejection_reason' => $reason,

            ]);


            /*
            |--------------------------------------------------------------------------
            | 4. Return Updated Request
            |--------------------------------------------------------------------------
            */

            return $ownerRequest->refresh();
        });
    }
}