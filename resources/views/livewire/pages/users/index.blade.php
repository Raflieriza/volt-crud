<?php
use function Livewire\Volt\{state, mount, with, updated};
use App\Models\User;
use Illuminate\Support\Facades\Hash;



state(['id','data', 'name','email','search', 'user', 'proses']);




mount(function(){
    $this->proses[] = 'sedang di mount';
});

$updatedSearch = function ()
{
    $this->resetPage();
};

with(function()
{
    $data = User::where('name','like','%'.$this->search.'%')->latest()->paginate(10);
    return [
        'users' => $data
    ];
});


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

$delete = function($id) {
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

<div>
    <div class="p-5">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <input type="text" wire:model.lazy="search">
        <a href="{{ route('users.create') }}">
            <button class="btn btn-primary">Create</button>
        </a>


        <ul>
            @foreach($users as $item)
                <li>
                    <a href="{{ route('users.edit',$item->id) }}">{{ $item->name }}</a>
                    <button class="btn btn-danger" wire:click="delete({{ $item->id }})" wire:confirm="lol">Delete</button>
                </li>
            @endforeach
        </ul>
        {{ $users->links() }}
    </div>
</div>
