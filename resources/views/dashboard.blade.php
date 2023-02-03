<x-app-layout>

    <div class="row">
        <nav id="" class="col-6">
            <div class="">
                <a href="{{ route('profile.edit') }}" class="img logo rounded-circle mb-5"
                    style="background: url({{ asset('images/admin.jpg') }}) left top / cover no-repeat">
                </a>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="{{ route('admin.createUser') }}">Créer un utilisateur</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.createCategory') }}">Créer les catégories et les verbatims</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.category') }}">Liste des catégories et des verbatims</a>
                    </li>
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Noter les verbatim</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                          @foreach($getCategory as $category)
                          <li>
                            <a href="{{ route('admin.noteVerba',['id_category' => $category->id_category]) }}">{{ $category->title }}</a>
                          </li>
                          @endforeach
                        </ul>
                      </li>
                </ul>

                <div class="footer">
                    <p>
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Prij
                    </p>
                </div>

            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 col-6">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

</x-app-layout>