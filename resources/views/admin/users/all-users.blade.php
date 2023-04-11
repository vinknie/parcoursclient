@extends('master')
@section('content')

<div class="text-center mt-20 mb-4">
   <h1 class="text-2xl font-semibold page-titles">Utilisateurs</h1>
</div>


<div class="user-table">
   @if(session('success'))
   <div class="success-msg">
      <p>{{ session('success') }}</p>
      <span class="success__cross-btn"><i class="fa-solid fa-xmark"></i></span>
   </div>
   @endif
   <table class="text-center rounded w-full">
      <thead class="text-white tracking-wider">
         <tr class="bg-gray-800">
            <th class="py-3"><b>Nom</b></th>
            <th class="py-3">E-mail</th>
            <th class="py-3">Date de création</th>
            <th class="py-3">Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach($users as $user)
         <tr class="border-b-2">
            <td class="py-2 cursor-pointer"><b>{{ ucfirst($user->name) }}</b></td>
            <td class="py-2"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            <td class="py-2">{{ $user->created_at ?? '--' }}</td>
            <td class="py-2">
               <a href="{{ route('admin.editUser', ['id_user' => $user->id]) }}"><i
                     class="fa-solid fa-user-pen text-gray-700"></i></a>
               <span class="font-bold text-lg">/</span>
               <a href="{{ route('admin.deleteUser', ['id_user' => $user->id]) }}"><i
                     class="fa-solid fa-user-xmark text-red-700"></i></a>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>

   <div class="mt-4">
      {{ $users->links() }}
   </div>
</div>

{{-- trashed section --}}
<div class="trash-user-container user-table">
   <h2 class="cursor-pointer">
      Trashed <span class="bg-gray-800 px-2 text-white rounded">{{ count($trashedUsers)}}</span>
      <i class="fa-solid fa-eye-slash"></i>
   </h2>
   <div id="trashed-usertable" class="hidden mt-2">
      <table class="text-center rounded w-full">
         <thead class="text-white tracking-wider">
            <tr class="bg-gray-800">
               <th class="py-3"><b>Nom</b></th>
               <th class="py-3">E-mail</th>
               <th class="py-3">Date de suppression</th>
               <th class="py-3">Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($trashedUsers as $tu)
            <tr class="border-b-2">
               <td class="py-3"><b>{{ $tu->name }}</b></td>
               <td class="py-3">{{ $tu->email }}</td>
               <td class="py-3">{{ $tu->deleted_at }}</td>
               <td class="py-3">
                  <a href="{{ route('admin.restoreUser', $tu->id) }}"
                     class="border bg-gray-800 px-2 py-1 text-white rounded">
                     Restore <i class="fa-solid fa-trash-can-arrow-up"></i>
                  </a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>

      <div class="mt-4">
         {{ $trashedUsers->links() }}
      </div>
   </div>
</div>
@endsection