<x-app-layout>

    <div class="flex flex-wrap md:flex-no-wrap min-h-screen">

        {{-- sidebar --}}
        <nav class="w-none md:w-1/6 bg-gray-800 text-slate-50 p-5">
            <div>
                <a href="{{ route('profile.edit') }}" class="block h-36 w-36 rounded-full mx-auto my-12"
                    style="background: url({{ asset('images/admin.jpg') }}) left center / cover no-repeat">
                </a>
                <ul class="divide-y divide-solid divide-slate-600">
                    <li class="py-4">
                        <a href="{{ route('admin.createUser') }}">Créer un utilisateur</a>
                    </li>
                    <li class="py-4">
                        <a href="{{ route('admin.createCategory') }}">Créer les catégories et les verbatims</a>
                    </li>
                    <li class="py-4">
                        <a href="{{ route('admin.category') }}">Liste des catégories et des verbatims</a>
                    </li>
                    <li class="py-4">
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">Noter les verbatim
                        </a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            @foreach($getCategory as $category)
                            <li class="py-4 px-2 text-white">
                                <a href="{{ route('admin.noteVerba',['id_category' => $category->id_category]) }}">{{
                                    $category->title }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>

                <div class="mt-10">
                    <p>
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Prij
                    </p>
                </div>

            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="w-full md:w-5/6">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

</x-app-layout>