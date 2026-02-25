<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UsersIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterRole = '';
    
    // Modal states
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public bool $showDeleteModal = false;
    
    // Form data
    public ?int $editingUserId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'santri';
    
    protected $queryString = ['search', 'filterRole'];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,guru,santri,wali',
        ];
        
        if (!$this->editingUserId) {
            $rules['email'] .= '|unique:users,email';
            $rules['password'] = 'required|min:8';
        } else {
            $rules['email'] .= '|unique:users,email,' . $this->editingUserId;
            $rules['password'] = 'nullable|min:8';
        }
        
        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'password', 'role', 'editingUserId']);
        $this->role = 'santri';
        $this->showCreateModal = true;
    }

    public function openEditModal(int $userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->showEditModal = true;
    }

    public function confirmDelete(int $userId)
    {
        $this->editingUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function createUser()
    {
        $this->validate();
        
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);
        
        $this->showCreateModal = false;
        $this->reset(['name', 'email', 'password', 'role']);
        session()->flash('success', 'User berhasil ditambahkan.');
    }

    public function updateUser()
    {
        $this->validate();
        
        $user = User::findOrFail($this->editingUserId);
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
        
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }
        
        $user->update($data);
        
        $this->showEditModal = false;
        $this->reset(['name', 'email', 'password', 'role', 'editingUserId']);
        session()->flash('success', 'User berhasil diupdate.');
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->editingUserId);
        
        if ($user->role === 'admin') {
            session()->flash('error', 'Admin tidak dapat dihapus.');
            $this->showDeleteModal = false;
            return;
        }
        
        $user->delete();
        
        $this->showDeleteModal = false;
        $this->reset(['editingUserId']);
        session()->flash('success', 'User berhasil dihapus.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%'))
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->latest()
            ->paginate(10);
        
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'guru' => User::where('role', 'guru')->count(),
            'santri' => User::where('role', 'santri')->count(),
            'wali' => User::where('role', 'wali')->count(),
        ];

        return view('livewire.admin.users.users-index', [
            'users' => $users,
            'stats' => $stats,
        ]);
    }
}
