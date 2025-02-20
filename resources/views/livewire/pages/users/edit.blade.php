<?php

use function Livewire\Volt\{state, mount, updated};
use App\Models\User;


state(['id', 'data', 'name', 'email']);
mount(function ($id) {
    $this->id = $id;
    $this->data = User::find($id);

    $this->name = $this->data->name;
    $this->email = $this->data->email;
});

$update = function () {
    $this->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users,email,' . $this->id,
    ]);

    $this->data->name = $this->name;
    $this->data->email = $this->email;
    $this->data->save();

    session()->flash('message', 'Data updated successfully.');
};


?>

<div>
    <form wire:submit.prevent="update">
        <label>Name:</label>
        <input type="text" wire:model="name">
        @error('name')
        <p class="text-red-500">{{ $message }}</p>
        @enderror

        <label>Email:</label>
        <input type="text" wire:model="email">
        @error('email')
        <p class="hover:underline text-red-500 hover:text-blue-500">{{ $message }}</p>
        @enderror

        <button type="submit">Update</button>
        <button class="text-white px-4 sm:px-8 py-2 sm:py-3 bg-sky-700 hover:bg-sky-800">...</button>

    </form>

    @if (session()->has('message'))
        <p>{{ session('message') }}</p>
    @endif
</div>

