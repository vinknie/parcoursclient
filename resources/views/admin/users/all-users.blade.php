@extends('master')
@section('content')

<style>
   .user-table {
      width: 90%;
      margin: auto;
   }
</style>

<div class="text-center mt-20 mb-4">
   <h1 class="text-2xl font-semibold page-titles">Utilisateurs</h1>
</div>

<div class="user-table">
   <table class="text-center rounded w-full">
      <thead class="text-white tracking-wider">
         <tr class="bg-gray-800">
            <th class="py-3"><b>Nom</b></th>
            <th class="py-3">E-mail</th>
            <th class="py-3">Role</th>
            <th class="py-3">Date de création</th>
            <th class="py-3">Action</th>
         </tr>
      </thead>
      <tbody>
         @foreach($users as $user)
         <tr class="border-b-2">
            <td class="py-2 cursor-pointer">{{ $user->name }}</td>
            <td class="py-2"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            <td class="py-2">{{ ($user->role) }}</td>
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
@endsection