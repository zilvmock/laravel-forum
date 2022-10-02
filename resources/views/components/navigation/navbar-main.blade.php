<div class="p-0 sm:p-4">
  <div class="navbar bg-base-100 shadow-md rounded">
    <div class="flex-1">
      <a href="{{ route('browse') }}" class="btn btn-ghost normal-case text-xl">
        <x-icons.application-logo class="block h-10 w-auto fill-current text-white"/>
      </a>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal p-0">
        <li><a href="{{ route('browse') }}">Browse</a></li>
      </ul>
      <x-navigation.dropdown>
        <x-slot:image>
          <div class="avatar">
            <div class="w-8 mr-3 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
              <img alt="user avatar"
                   src="{{auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar)
                         : asset('storage/avatars/no-avatar.jpg')}}"/>
            </div>
          </div>
        </x-slot:image>
        <x-slot:title>{{ Auth::user()->username }}</x-slot:title>
        <x-slot:icon>
          <x-icons.daisy.chevron-down/>
        </x-slot:icon>
        <x-slot:content>
          <li class="bg-base-200 font-bold border-b-2 p-1">Profile</li>
          <li><a href="{{ route('profile') }}">My Profile</a></li>
          <li><a href="{{ route('edit-profile') }}">Edit Profile</a></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout</a>
            </form>
          </li>
        </x-slot:content>
      </x-navigation.dropdown>
    </div>
  </div>
</div>
