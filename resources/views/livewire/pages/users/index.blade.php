<?php

use function Livewire\Volt\{state, mount, with, updated, usesPagination};
use App\Models\User;
use Illuminate\Support\Facades\Hash;

usesPagination();


state(['id', 'data', 'name', 'email', 'search', 'user', 'proses']);

mount(function () {
    $this->proses[] = 'sedang di mount';
});


with(function () {
    $data = User::where('name', 'like', '%' . $this->search . '%')->latest()->paginate(10);
    return [
        'users' => $data
    ];
});

$updatedSearch = function () {
    $this->resetPage();
};


//$with = function ()
//{
//    $data = User::where('name','like','%'.$this->search.'%')->latest()->paginate(10);
//    return [
//        'users' => $data
//    ];
//});


//$updatedName = function($casd){
//
//}

$delete = function ($id) {
    $user = User::find($id);

    if ($user) {
        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
    } else {
        session()->flash('error', 'User tidak ditemukan.');
    }

    return redirect()->back();
};

?>

<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Home</a></li>
            <li>Users</li>
        </ul>
    </div>
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Users</h2>
            <div class="flex justify-between">
                <input type="text" class="input input-bordered w-full max-w-xs"
                       wire:model.lazy="search" placeholder="Type name"/>
                <a href="{{ route('users.create') }}" class="btn btn-primary">Create</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href="{{ route('users.edit',$item->id) }}" class="btn btn-xs btn-warning">Edit</a>
                                <button wire:confirm="Are you sure?" wire:click="delete({{ $item->id }})"
                                        class="btn btn-xs btn-error">Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>
</div>
