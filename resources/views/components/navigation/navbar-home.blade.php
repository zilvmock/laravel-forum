<div class="p-0 sm:p-4 flex justify-center">
  <div class="navbar bg-base-100 shadow-md rounded w-11/12">
    <div class="flex-1">
      <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl">
        <x-icons.application-logo class="block h-10 w-auto fill-current text-white pr-2"/>
        Interstartas
      </a>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal p-0">
        <li><a href="{{route('browse')}}">Forum</a></li>
      </ul>
    </div>
  </div>
</div>
