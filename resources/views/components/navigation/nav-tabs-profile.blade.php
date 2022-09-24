<div class="tabs pl-8">
  <a class="tab tab-lifted
       {{ (request()->segment(2) == 'profile') ? 'tab-active' : '' }}"
     href="{{route('profile')}}"
  >
    <x-icons.heroicons.user-circle/>
    Profile</a>
  <a class="tab tab-lifted
       {{ (request()->segment(2) == 'edit-profile') ? 'tab-active' : '' }}"
     href="{{route('edit-profile')}}"
  >
    <x-icons.heroicons.pencil-square/>
    Edit Profile</a>
</div>
