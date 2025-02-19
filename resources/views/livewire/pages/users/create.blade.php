<?php

use function Livewire\Volt\{state};
use App\Models\User;
use Illuminate\Support\Facades\Hash;

state(['name','email', 'password']);

$create = function () {
    $this->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:4',
    ]);

    User::create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => Hash::make($this->password),
    ]);

    session()->flash('message', 'User berhasil ditambahkan.');
    $this->reset(['name', 'email', 'password']);
};

?>

<div>
     <h3>Tambah User</h3>
    <input type="text" wire:model="name" placeholder="Name">
    <input type="email" wire:model="email" placeholder="Email">
    <input type="password" wire:model="password" placeholder="Password">
    <button class="btn btn-success" wire:click="create">Tambah</button>

@if (session()->has('message'))
    <p>{{ session('message') }}</p>
    @endif
</div>
