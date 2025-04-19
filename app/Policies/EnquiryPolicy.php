<?php

namespace App\Policies;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnquiryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any enquiries.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the enquiry.
     */
    public function view(User $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin() || $user->id === $enquiry->user_id || $user->id === $enquiry->assigned_mentor_id;
    }

    /**
     * Determine whether the user can create an enquiry.
     */
    public function create(User $user): bool
    {
        return true; // Anyone can create an enquiry
    }

    /**
     * Determine whether the user can assign mentors to enquiries.
     */
    public function assignMentor(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can convert enquiries to appointments.
     */
    public function convertToAppointment(User $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin() && $enquiry->isAssigned();
    }

    /**
     * Determine whether the user can reject enquiries.
     */
    public function reject(User $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin() && $enquiry->isPending();
    }

    /**
     * Determine whether the user can update the enquiry.
     */
    public function update(User $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin();
    }
} 