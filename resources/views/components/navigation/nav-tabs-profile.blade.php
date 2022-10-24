<div class="tabs pl-8 pt-2 font-bold">
  <a class="tab tab-lifted
       {{ (request()->segment(2) == 'profile') ? 'tab-active' : 'text-black' }}"
     href="{{route('profile')}}"
  >
    <x-icons.heroicons.user-circle/>
    Profile</a>
  <a class="tab tab-lifted
       {{ (request()->segment(2) == 'edit-profile') ? 'tab-active' : 'text-black' }}"
     href="{{route('edit_profile')}}"
  >
    <x-icons.heroicons.pencil-square/>
    Edit Profile</a>
</div>
