<x-app-layout>
  <div class="flex-row">
    <x-navigation.nav-tabs-profile/>
    {{-- Profile Overview --}}
    <x-layout.card class="p-8 w-screen sm:w-full">
      {{--            <button class="btn btn-sm btn-ghost">--}}
      {{--                <a href="{{route('edit-profile')}}"><x-icons.heroicons.cog6/></a>--}}
      {{--            </button>--}}
      <div class="md:grid flex-col overflow-hidden grid-cols-3 grid-rows-2 gap-1">
        <div class="row-span-2 text-center">
          <div class="avatar">
            <div class="w-48 rounded-full shadow-lg">
              <img alt="user avatar" src="{{auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar)
                                    : asset('storage/avatars/no-avatar.jpg')}}"/>
            </div>
          </div>
        </div>
        {{-- Profile Main Info--}}
        <div class="col-start-2 col-span-2 min-w-fit">
          <div class="prose grid">
            <b class="lg:text-4xl sm:text-2xl uppercase">
              {{auth()->user()->first_name}} {{auth()->user()->last_name}}
            </b>
            <i class="lg:text-2xl sm:text-lg">
              {{auth()->user()->username}}
            </i>
            <div>
              <span class="badge bg-accent text-black">Reputation: 0</span>
              <span class="badge w-auto">Member since:
                        {{date('Y-m-d', strtotime(auth()->user()->created_at))}}
                        </span>
              <span class="badge">Posts: 0</span>
              <span class="badge">Something else: 0</span>
            </div>
          </div>
        </div>
        {{-- Bio --}}
        <div class="col-span-2 mt-2 pr-2">
          {!! auth()->user()->bio !!}
        </div>
      </div>
    </x-layout.card>
  </div>
</x-app-layout>
