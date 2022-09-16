{{-- Dashboard Navbar --}}
@php($Active='bordered bg-gray-100 rounded mx-2')
<div class="flex">
    <h2 id="header" class="font-semibold text-xl uppercase leading-tight rounded p-1 mr-2 bg-gradient-to-r from-primary-content">
{{--        style="border-radius: 5px;--}}
{{--               background: linear-gradient(145deg, #e6e6e6, #ffffff);--}}
{{--               box-shadow:  5px 5px 0px #fcfcfc,--}}
{{--               -5px -5px 0px #ffffff;">--}}
        {{ __('Dashboard') }}
    </h2>
    <div id="header-arrow" class="p-1"><x-icons.double-arrow-right/></div>

    <div class="dropdown">
        <label id="barsBtn" tabindex="0" class="btn btn-primary hidden"><x-icons.bars3/></label>
        <ul id="dashboard-navbar" tabindex="0" class="menu menu-horizontal rounded-box w-80 bg-base-100 w-max">
            <!-- Sidebar content here -->
            <li class="{{ (request()->is('dashboard/profile*')) ? $Active : '' }}">
                <a class="sb h-4 p-4 px-2 hover:bg-gray-200" href="{{route('profile')}}">
                    <x-icons.profile/>Profile</a>
            </li>
            <li class="{{ (request()->is('dashboard/edit-profile')) ? $Active : '' }}">
                <a class="sb h-4 p-4 px-2 hover:bg-gray-200" href="{{route('edit-profile')}}">
                    <x-icons.edit/>Edit profile</a>
            </li>
        </ul>
    </div>
</div>
<script>
    window.addEventListener('load', () => {
        changeSize();
        window.addEventListener('resize', () => {
            changeSize();
        });
    });
    let btn = document.getElementById('barsBtn');
    let header = document.getElementById('header');
    let headerArrow = document.getElementById('header-arrow');
    function changeSize() {
        let ul = document.getElementById('dashboard-navbar');
        if (document.body.scrollWidth <= 540) {
            if (!ul.classList.contains('dropdown-content')) {
                ul.classList = '';
                ul.classList.add('dropdown-content', 'menu', 'p-2', 'shadow', 'bg-base-100', 'rounded-box', 'w-80', 'w-max');
                btn.classList.remove('hidden');
                header.classList.add('hidden')
                headerArrow.classList.add('hidden')
            }
        } else {
            if (!ul.classList.contains('menu-vertical')) {
                ul.classList = '';
                ul.classList.add('menu', 'menu-horizontal', 'rounded-box', 'w-80', 'bg-base-100', 'w-max');
                btn.classList.add('hidden');
                header.classList.remove('hidden')
                headerArrow.classList.remove('hidden')
            }
        }
    }
</script>
