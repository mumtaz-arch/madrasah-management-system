<?php

namespace App\Policies;

use App\Models\TeacherJournal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeacherJournalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdminOrOperator() || $user->isGuru();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TeacherJournal $teacherJournal): bool
    {
        if ($user->isAdminOrOperator()) {
            return true;
        }

        return $user->isGuru() && $teacherJournal->teacher_id === $user->guru->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isGuru();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TeacherJournal $teacherJournal): bool
    {
        if ($user->isAdminOrOperator()) {
            return true;
        }

        // Guru can only update their own draft journals
        return $user->isGuru() 
            && $teacherJournal->teacher_id === $user->guru->id
            && $teacherJournal->status === TeacherJournal::STATUS_DRAFT;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TeacherJournal $teacherJournal): bool
    {
        if ($user->isAdminOrOperator()) {
            return true;
        }

        // Guru can only delete their own draft journals
        return $user->isGuru() 
            && $teacherJournal->teacher_id === $user->guru->id
            && $teacherJournal->status === TeacherJournal::STATUS_DRAFT;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TeacherJournal $teacherJournal): bool
    {
        return $user->isAdminOrOperator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TeacherJournal $teacherJournal): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can verify the journal.
     */
    public function verify(User $user): bool
    {
        return $user->isAdminOrOperator();
    }
}
