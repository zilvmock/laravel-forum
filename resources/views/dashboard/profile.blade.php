<x-app-layout>
  <div class="grid place-items-center">
    <x-navigation.nav-tabs-profile/>
    {{-- Profile Overview --}}
    <x-layout.card class="p-8 sm:mx-4 mx-0 xl:w-4/6 lg:w-4/5">
      <div class="md:grid flex-col overflow-hidden grid-cols-3 grid-rows-2 gap-1">
        <div class="row-span-2 text-center p-4">
          <div class="avatar">
            <div class="w-48 rounded-full shadow-lg ring-4 ring-primary ring-offset-base-100 ring-offset-2">
              <img alt="user avatar" src="{{asset('storage/'.auth()->user()->avatar)}}"/>
            </div>
          </div>
        </div>
        {{-- Profile Main Info--}}
        <div class="col-start-2 col-span-2 min-w-fit p-4">
          <div class="grid bg-secondary/10 p-4 rounded">
            <b class="sm:text-4xl text-2xl uppercase">
              {{auth()->user()->first_name}} {{auth()->user()->last_name}}
            </b>
            <div class="flex justify-between py-1">
              <div class="lg:text-2xl text-lg mr-4">
                <small class="text-sm">Goes by:</small> {{auth()->user()->username}}
              </div>
              <div class="badge font-gemunu bg-gradient-to-t
              {{auth()->user()->role == 1 ? 'from-red-900 to-error' : 'from-primary to-blue-500'}}
               text-lg mb-2 p-3 rounded">
                {{auth()->user()->getRole(auth()->user())}}
              </div>
            </div>
            <div class="py-2">
              <span class="badge font-gemunu bg-gradient-to-t from-green-900 to-success text-lg mb-2 p-3 rounded">
                Reputation: {{auth()->user()->getReputation(auth()->user())}}
              </span>
              <span class="badge font-gemunu bg-gradient-to-t from-secondary/10 to-secondary text-lg mb-2 p-3 rounded">
                Member since: {{date('Y-m-d', strtotime(auth()->user()->created_at))}}
              </span>
              <span class="badge font-gemunu bg-gradient-to-t from-secondary/10 to-secondary text-lg mb-2 p-3 rounded">
                Posts: {{auth()->user()->getNumOfPosts(auth()->user())}}
              </span>
            </div>
          </div>
        </div>
        {{-- Bio --}}
        @if(auth()->user()->bio)
          <div class="col-span-2 mt-2 pr-2 w-auto overflow-auto break-normal bg-secondary/10 p-4 m-4 rounded">
            {!! auth()->user()->bio !!}
          </div>
        @endif
      </div>
    </x-layout.card>
  </div>
</x-app-layout>
