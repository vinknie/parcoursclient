<x-app-layout>
    @dd($categoryWithVerbatim)

    {{-- @dd($categoryWithVerbatim) --}}
    <div class="flex flex-wrap md:flex-no-wrap min-h-screen">

        {{-- sidebar --}}
        <nav class="w-none md:w-1/6 bg-gray-800 text-slate-50 p-5">

            <a href="{{ route('profile.edit') }}" class="block h-36 w-36 rounded-full mx-auto my-12"
                style="background: url({{ asset('images/admin.jpg') }}) left center / cover no-repeat">
            </a>
            <ul class="divide-y divide-solid divide-slate-600">


                @if(Auth::user()->role == 'admin')
                <li class="py-2">
                    <x-responsive-nav-link :href="route('admin.createUser')"
                        :active="request()->routeIs('admin.createUser')">
                        {{ __('Créer un utilisateur') }}
                    </x-responsive-nav-link>
                    @endif
                </li>

                <li class="py-2">
                    <x-responsive-nav-link :href="route('admin.createCategory')"
                        :active="request()->routeIs('admin.createCategory')">
                        {{ __('Créer les catégories et les verbatims') }}
                    </x-responsive-nav-link>
                </li>

                <li class="py-2">
                    <x-responsive-nav-link :href="route('admin.category')"
                        :active="request()->routeIs('admin.category')">
                        {{ __('Liste des catégories et des verbatims') }}
                    </x-responsive-nav-link>
                </li>

                <li class="py-2">
                    @if (Route::currentRouteNamed(null) || str_contains(Route::currentRouteName(),'note'))
                    <x-responsive-nav-link href="#pageSubmenu" :active=true data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">
                        {{ __('Noter les verbatim') }}
                    </x-responsive-nav-link>
                    @else
                    <x-responsive-nav-link href="#pageSubmenu" :active="false" data-toggle="collapse"
                        aria-expanded="false" class="dropdown-toggle">
                        {{ __('Noter les verbatim') }}
                    </x-responsive-nav-link>
                </li>
                @endif
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    @foreach($getCategory as $category)
                    <li class="py-2 px-2 text-white">
                        <a href="{{ route('admin.noteVerba',['id_category' => $category->id_category]) }}">{{
                            $category->title }}</a>
                    </li>
                    @endforeach
                </ul>
            </ul>

            <div class="mt-10">
                <p>
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | Prij
                </p>
            </div>
        </nav>


        <div class="" style="overflow-x: scroll;">
            <canvas id="myChart" height="700"></canvas>
        </div>
        @foreach($categoryWithVerbatim as $catWithVerb)
        {
        label: {{$catWithVerb->title}},
        {{-- backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1,
        stack: 'Stack 0', --}}
        data: [{{ $catWithVerb->positif }}]
        },
        {{-- {{ $catWithVerb->title}} --}}
        @endforeach

        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [
                        {
                        label: 'Dataset 1',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        stack: 'Stack 0',
                        data: [10, 20, -30, 40, -50, 60]
                    },
                    {
                        label: 'Dataset 2',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        stack: 'Stack 0',
                        data: [-10, -20, 30, -40, 50, -60]
                    }
                ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            },
                            stacked: true
                        }]
                    }
                }
            });
        </script>

        <!-- Page Content  -->
        <div id="content" class="w-full md:w-5/6">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

</x-app-layout>