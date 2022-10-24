<x-app-layout>
  <div class="md:m-4 md:p-2 mt-2 md:w-9/12 w-full">
    <x-navigation.nav-tabs-profile/>
    <x-layout.card class="rounded-none rounded-t md:rounded">
      <div
        class="lg:grid flex-col overflow-hidden grid-cols-3 {{auth()->user()->bio ? 'grid-rows-2' : 'grid-rows-1'}} gap-1">
        <div class="row-span-2 text-center p-4">
          <div class="avatar">
            <div class="w-48 rounded-full shadow-lg ring-4 ring-primary ring-offset-base-100 ring-offset-2">
              <img alt="user avatar" src="{{asset('storage/'.auth()->user()->avatar)}}"/>
            </div>
          </div>
        </div>
        <div class="col-start-2 col-span-2 min-w-fit p-4">
          <div class="grid bg-secondary/10 p-4 rounded">
            <b class="sm:text-4xl text-2xl uppercase">
              {{auth()->user()->first_name}} {{auth()->user()->last_name}}
            </b>
            <div class="flex justify-between py-1">
              <div class="lg:text-2xl text-lg mr-4">
                <small class="text-sm">Goes by:</small> {{auth()->user()->username}}
              </div>
            </div>
            <div class="py-2">
              <span class="badge font-gemunu bg-gradient-to-t from-secondary/10 to-secondary text-lg mb-2 p-3 rounded">
                Member since: {{date('Y-m-d', strtotime(auth()->user()->created_at))}}
              </span>
              <div
                class="badge font-gemunu bg-gradient-to-t {{auth()->user()->role == 1 ? 'from-red-900 to-error' : 'from-primary to-blue-500'}} text-lg mb-2 p-3 rounded">
                {{auth()->user()->getRoleName(auth()->user())}}
              </div>
            </div>
          </div>
        </div>
        {{-- Bio --}}
        @if(auth()->user()->bio)
          <div class="col-span-2 mt-2 pr-2 w-auto h-max overflow-auto break-all bg-secondary/10 p-4 m-4 rounded">
            {!! auth()->user()->bio !!}
          </div>
        @endif
      </div>
    </x-layout.card>
  </div>
</x-app-layout>
