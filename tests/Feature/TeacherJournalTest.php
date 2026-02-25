<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TeacherJournal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeacherJournalTest extends TestCase
{
    use RefreshDatabase;

    protected $guruUser;
    protected $guru;
    protected $adminUser;
    protected $kelas;
    protected $mapel;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Admin
        $this->adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create Guru User and Guru Profile
        $this->guruUser = User::factory()->create([
            'name' => 'Guru User',
            'email' => 'guru@example.com',
            'role' => 'guru',
        ]);

        $this->guru = Guru::create([
            'user_id' => $this->guruUser->id,
            'nip' => '1234567890',
            'nama_lengkap' => 'Guru User',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Test',
            'no_hp' => '081234567890',
            'status_kepegawaian' => 'Tetap',
        ]);

        // Create Kelas and Mapel
        $this->kelas = Kelas::create(['nama_kelas' => 'X IPA 1']);
        $this->mapel = Mapel::create(['nama' => 'Matematika', 'kode' => 'MTK']);
    }

    public function test_guru_can_view_journal_index()
    {
        $response = $this->actingAs($this->guruUser)->get(route('guru.journal.index'));
        $response->assertStatus(200);
    }

    public function test_guru_can_create_journal()
    {
        $response = $this->actingAs($this->guruUser)->post(route('guru.journal.store'), [
            'date' => now()->format('Y-m-d'),
            'class_id' => $this->kelas->id,
            'subject_id' => $this->mapel->id,
            'topic' => 'Aljabar',
            'method' => 'Ceramah',
            'present_count' => 30,
            'absent_count' => 0,
            'notes' => 'Lancar',
            'status' => 'draft',
        ]);

        $response->assertRedirect(route('guru.journal.index'));
        $this->assertDatabaseHas('teacher_journals', [
            'topic' => 'Aljabar',
            'status' => 'draft',
            'teacher_id' => $this->guru->id,
        ]);
    }

    public function test_guru_cannot_create_journal_with_future_date()
    {
        $response = $this->actingAs($this->guruUser)->post(route('guru.journal.store'), [
            'date' => now()->addDay()->format('Y-m-d'), // Future date
            'class_id' => $this->kelas->id,
            'subject_id' => $this->mapel->id,
            'topic' => 'Future Topic',
            'method' => 'Future Method',
            'present_count' => 30,
            'absent_count' => 0,
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('date');
    }

    public function test_guru_can_update_draft_journal()
    {
        $journal = TeacherJournal::create([
            'teacher_id' => $this->guru->id,
            'class_id' => $this->kelas->id,
            'subject_id' => $this->mapel->id,
            'date' => now()->format('Y-m-d'),
            'topic' => 'Old Topic',
            'method' => 'Old Method',
            'present_count' => 30,
            'absent_count' => 0,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->guruUser)->put(route('guru.journal.update', $journal), [
            'date' => now()->format('Y-m-d'),
            'class_id' => $this->kelas->id,
            'subject_id' => $this->mapel->id,
            'topic' => 'New Topic',
            'method' => 'New Method',
            'present_count' => 30,
            'absent_count' => 0,
            'status' => 'sent',
        ]);

        $response->assertRedirect(route('guru.journal.index'));
        $this->assertDatabaseHas('teacher_journals', [
            'id' => $journal->id,
            'topic' => 'New Topic',
            'status' => 'sent',
        ]);
    }

    public function test_guru_cannot_update_sent_journal()
    {
        $journal = TeacherJournal::create([
            'teacher_id' => $this->guru->id,
            'class_id' => $this->kelas->id,
            'subject_id' => $this->mapel->id,
            'date' => now()->format('Y-m-d'),
            'topic' => 'Sent Topic',
            'method' => 'Sent Method',
            'present_count' => 30,
            'absent_count' => 0,
            'status' => 'sent',
        ]);

        $response = $this->actingAs($this->guruUser)->put(route('guru.journal.update', $journal), [
            'date' => now()->format('Y-m-d'),
            'class_id' => $this->kelas->id,
            'subject_id' => $this->mapel->id,
            'topic' => 'Hacked Topic',
            'method' => 'Hacked Method',
            'present_count' => 30,
            'absent_count' => 0,
            'status' => 'sent',
        ]);

        // Policy should deny update
        $response->assertStatus(403);
    }

    public function test_admin_can_view_journal_index()
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.journal.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_verify_journal()
    {
        $journal = TeacherJournal::create([
            'teacher_id' => $this->guru->id,
            'class_id' => $this->kelas->id,
            'subject_id' => $this->mapel->id,
            'date' => now()->format('Y-m-d'),
            'topic' => 'To Verify',
            'method' => 'Method',
            'present_count' => 30,
            'absent_count' => 0,
            'status' => 'sent',
        ]);

        $response = $this->actingAs($this->adminUser)->patch(route('admin.journal.verify', $journal));

        $response->assertRedirect();
        $this->assertDatabaseHas('teacher_journals', [
            'id' => $journal->id,
            'status' => 'verified',
            'verified_by' => $this->adminUser->id,
        ]);
    }
}
