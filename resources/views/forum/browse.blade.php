<x-app-layout>
  <div class="md:m-4 md:p-2 mt-2 md:w-9/12">
    <x-navigation.recent-articles :latestArticles="$latestArticles"/>
    <x-layout.card class="rounded-none rounded-t md:rounded">
      {{-- Admin Controls --}}
      @if(auth()->user()->role == 1)
        <x-layout.card class="bg-secondary/10 mb-2">
          <div>
            <form action="{{route('create_group')}}" method="post">
              @csrf
              @method('GET')
              <button class="btn btn-sm btn-ghost bg-red-900 p-2 mx-2">Add New Group</button>
            </form>
          </div>
        </x-layout.card>
      @endif
      @foreach($groups as $group)
        <x-layout.card class="md:flex items-center">
          <div class="flex items-center">
            {{-- Admin Controls --}}
            @if(auth()->user()->role == 1)
              <x-layout.modal-button :elIdName="$group['id'].'G'">
                <x-icons.heroicons.trash/>
              </x-layout.modal-button>
              <form action="{{route('edit_group', $group['id'])}}" method="post">
                @csrf
                @method('GET')
                <x-input.edit-button class="text-error"/>
              </form>
              <form action="{{route('create_category', $group['id'])}}" method="post">
                @csrf
                @method('GET')
                <button class="btn btn-sm btn-ghost bg-red-900 p-2 mx-2 h-full">Add New Category</button>
              </form>
              <x-layout.modal :title="'Delete Group'" :elId="$group['id']" :route="'delete_group'"
                              :elIdName="$group['id'].'G'">
                <x-slot:text>
                  Are you sure you want to delete this group?<br>
                  <b class="text-error">All categories with articles and their data will be deleted as well!</b><br>
                  To avoid this please assign categories to different group.<br>
                  Click <b>YES</b> to confirm, <b>NO</b> to cancel.
                </x-slot:text>
              </x-layout.modal>
            @endif
          </div>
          <div>
            <h1 class="text-lg font-bold m-0">{{$group['title']}}</h1>
          </div>
        </x-layout.card>
        @if(!$empty->contains($group['id']))
          <div class="badge badge-info gap-2 p-4 m-4">
            <x-icons.daisy.info-circle/>
            No Categories In This Section
          </div>
        @endif
        @foreach($categoriesData as $category)
          @if($category['group'] == $group['title'])
            <div class="md:flex items-center">
              <div class="grid pt-4 grid-cols-1 grid-rows-2 px-4 items-center place-items-center">
                <div class="row-start-1">
                  <x-icons.heroicons.chat-bubbles class="w-12"/>
                </div>
                <div class="row-start-2">
                  {{-- Admin Controls --}}
                  @if(auth()->user()->role == 1)
                    <div class="flex items-center">
                      <x-layout.modal-button :elIdName="$category['id'].'C'">
                        <x-icons.heroicons.trash/>
                      </x-layout.modal-button>
                      <form action="{{route('edit_category', $category['id'])}}" method="post">
                        @csrf
                        @method('GET')
                        <x-input.edit-button class="text-error"/>
                      </form>
                    </div>
                    <x-layout.modal :title="'Delete Category'" :elId="$category['id']"
                                    :elIdName="$category['id'].'C'"
                                    :route="'delete_category'">
                      <x-slot:text>
                        Are you sure you want to delete this category?<br>
                        <b class="text-error">All articles and their comments will be deleted as well!</b><br>
                        To avoid this please assign articles to different category.<br>
                        Click <b>YES</b> to confirm, <b>NO</b> to cancel.
                      </x-slot:text>
                    </x-layout.modal>
                  @endif
                </div>
              </div>
              <div class="divider divider-horizontal m-0 mr-2"></div>
              <div class="flex flex-col w-full pb-2 pr-4 ml-2">
                <a class="link link-hover font-bold text-secondary text-xl"
                   href="{{route('browse_category', [$category['slug'], 'id' => $category['id']])}}">
                  {{$category['title']}}
                </a>
                <p>{{$category['description']}}</p>
              </div>
              {{-- Latest article/comment in that category --}}
              @if($category['latestActivity'] != null)
                <a
                  class="w-full sm:w-3/6 p-2 flex xs:flex md:flex-col xl:flex-row xl:text-left text-left md:text-center justify-left items-center transition hover:bg-gray-300/10 duration-300 rounded"
                  href="{{route('view_article', [
                        'category' => $category['latestActivity'] instanceof \App\Models\Article ? $category['latestActivity']->category->slug
                        : $category['latestActivity']->article->category->slug,
                        'article' => $category['latestActivity'] instanceof \App\Models\Article ? $category['latestActivity']->slug
                        : $category['latestActivity']->article->slug,
                        'id' => $category['latestActivity'] instanceof \App\Models\Article ? $category['latestActivity']->id
                        : $category['latestActivity']->article->id])}}">
                  <div class="avatar xl:pr-2 pr-0">
                    <div class="w-12 h-12 rounded-full">
                      <img alt="user avatar" src="{{asset('storage/'.$category['latestActivity']->user->avatar)}}"/>
                    </div>
                  </div>
                  <div class="pl-2 break-all">
                    <b>{{$category['latestActivity']->user->username}}</b>
                    <p class="text-xs">Wrote At: {{$category['latestActivity']->created_at}}</p>
                  </div>
                </a>
              @else
                <a
                  class="w-full sm:w-3/6 p-2 flex xs:flex md:flex-col xl:flex-row xl:text-left text-left md:text-center justify-left items-center transition hover:bg-gray-300/10 duration-300 rounded"
                  href="#">
                  <div class="pl-2">
                    <b>No Recent Activity</b>
                  </div>
                </a>
              @endif
            </div>
            <div class="divider divider-vertical m-0"></div>
          @endif
        @endforeach
      @endforeach
    </x-layout.card>
  </div>
</x-app-layout>
