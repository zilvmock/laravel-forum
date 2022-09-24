<x-app-layout>
  {{-- All Topics --}}
  <div class="sm:flex">
    <x-layout.card class="m-4 p-4 sm:w-4/5">
      @foreach($groupNames as $groupName)
        <h1 class="font-bold text-lg">
          {{$groupName->group_name}}
        </h1>
        <div class="divider m-0"></div>
        @if(!$empty->contains($groupName->id))
          <div class="badge badge-info gap-2">
            <x-icons.daisy.info-circle/> No Categories For This Section
          </div>
        @endif
        @foreach($categories as $category)
          @if($category->group->group_name == $groupName->group_name)
            {{-- Category Info --}}
            <div class="flex rounded">
              <x-icons.heroicons.chat-bubbles class="w-12"/>
              <div class="divider divider-horizontal m-0 mr-2"></div>
              <div class="flex-col w-3/5">
                <a class="link link-hover font-bold text-secondary text-xl" href="#">
                  {{$category->title}}
                </a>
                <p>
                  {{$category->description}}
                </p>
                  <div class="divider m-0"></div>
              </div>
              {{-- Latest post/comment in that subcategory --}}
              <div class="divider divider-horizontal m-0 mx-2"></div>
              <a class="xl:flex p-2 transition hover:bg-gray-300/10 duration-300 rounded" href="#">
                <div class="avatar pr-2">
                  <div class="w-12 rounded-full">
                    <img src="https://placeimg.com/192/192/people"/>
                  </div>
                </div>
                <div class="flex-col pl-2">
                  <b>Petras Petraitis</b>
                  <p>Wrote at: Friday, 22:31</p>
                </div>
              </a>
            </div>
          @endif
        @endforeach
        <div class="divider m-0"></div>
      @endforeach
    </x-layout.card>
    {{-- Recent Topics --}}
    <x-layout.card class="m-4 sm:w-1/4 h-max p-4">
      <h1 class="font-bold">Recent Topics</h1>
      <div class="divider m-0"></div>
      <div class="rounded">
        <a class="link link-hover font-bold text-secondary text-md" href="#">Tips on How to Write Functions in C#</a>
        <p><b>By: Petras Petraitis</b>,<br>
          <small><i>Friday, 22:31</i></small>
        </p>
      </div>
    </x-layout.card>
  </div>
</x-app-layout>
