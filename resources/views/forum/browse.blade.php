<x-app-layout>
  {{-- All Topics --}}
  <div class="lg:flex">
    <x-navigation.recent-articles/>
    <x-layout.card class="sm:m-4 p-4 mt-2">
      {{-- Admin Controls --}}
      @if(auth()->user()->role == 1)
        <x-layout.card class="sm:flex justify-start overflow-hidden bg-secondary/10 mb-2">
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
        <x-layout.card class="bg-secondary/10 mb-2 pl-4 flex items-center">
          {{-- Admin Controls --}}
          @if(auth()->user()->role == 1)
            <x-layout.modal-button :elIdName="$group->id.'G'">
              <x-icons.heroicons.trash/>
            </x-layout.modal-button>
            <div class="text-error pr-2 ml-2">
              <form action="{{route('edit_group', $group->id)}}" method="post">
                @csrf
                @method('GET')
                <button class="btn btn-sm btn-ghost p-0.5" type="submit">
                  <x-icons.heroicons.pencil-square/>
                </button>
              </form>
            </div>
            <div>
              <form action="{{route('create_category', $group->id)}}" method="post">
                @csrf
                @method('GET')
                <button class="btn btn-sm btn-ghost bg-red-900 p-2 mx-2">Add New Category</button>
              </form>
            </div>
            <x-layout.modal :title="'Delete Group'" :elId="$group->id" :route="'delete_group'"
                            :elIdName="$group->id.'G'">
              <x-slot:text>
                Are you sure you want to delete this group?<br>
                <b class="text-error">All categories with articles and their data will be deleted as well!</b><br>
                To avoid this please assign categories to different group.<br>
                Click <b>YES</b> to confirm, <b>NO</b> to cancel.
              </x-slot:text>
            </x-layout.modal>
          @endif
          <h1 class="text-lg font-bold">{{$group->title}}</h1>
        </x-layout.card>
        @if(!$empty->contains($group->id))
          <div class="badge badge-info gap-2 p-4 m-4">
            <x-icons.daisy.info-circle/>
            No Categories In This Section
          </div>
        @endif
        @foreach($categories as $category)
          @if($category->group->title == $group->title)
            {{-- Category Info --}}
            <div class="flex rounded py-2">
              <div class="flex-col">
                <x-icons.heroicons.chat-bubbles class="w-12"/>
                {{-- Admin Controls --}}
                @if(auth()->user()->role == 1)
                  <div class="flex">
                    <x-layout.modal-button :elIdName="$category->id.'C'">
                      <x-icons.heroicons.trash/>
                    </x-layout.modal-button>
                    <div class="text-error pr-2 ml-2">
                      <form action="{{route('edit_category', $category->id)}}" method="post">
                        @csrf
                        @method('GET')
                        <button class="btn btn-sm btn-ghost p-0.5" type="submit">
                          <x-icons.heroicons.pencil-square/>
                        </button>
                      </form>
                    </div>
                  </div>
                  <x-layout.modal :title="'Delete Category'" :elId="$category->id"
                                  :elIdName="$category->id.'C'"
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
              <div class="divider divider-horizontal m-0 mr-2"></div>
              <div class="flex-col w-11/12 pb-2 pr-4">
                <a class="link link-hover font-bold text-secondary text-xl"
                   href="{{route('browse-category', $category)}}">
                  {{$category->title}}
                </a>
                <p>{{$category->description}}</p>
              </div>
              {{-- Latest article/comment in that category --}}
              @php
                // Find if group has any articles
                $groupArticles = $articles->where('category_id', '==', $category->id);
                if ($groupArticles == null) {
                    $latestActivity = null;
                } else {
                  // Latest article from current group
                  $latestArticle = $groupArticles->sortByDesc('created_at')->first();
                  // Find if there are comments in current category
                  // Adds to collection all the latest comments from each article in the current category.
                  $latestArticleComments = collect();
                  foreach ($groupArticles as $article) {
                      $comment = $comments->where('article_id', '==', $article->id)->sortByDesc('created_at')->first();
                      if ($comment != null) {
                        $latestArticleComments->push($comment);
                      }
                  }
                  // Skips categories with articles that have no comments or
                  // categories with no articles at all.
                  if ($latestArticleComments == null || $latestArticleComments->isEmpty()) {
                      $latestActivity = $latestArticle;
                  } else {
                    // Latest comment in current article
                    $latestComment = $latestArticleComments->sortByDesc('created_at')->first();
                    // Find the latest activity in that group
                    if ($latestArticle->created_at->format('His.u')<=$latestComment->created_at->format('His.u')) {
                      $latestActivity = $latestComment;
                    } else {
                      $latestActivity = $latestArticle;
                    }
                  }
                }
              @endphp
              @if($latestActivity != null)
                <a
                  class="lg:flex place-items-center w-3/6 p-2 transition hover:bg-gray-300/10 duration-300 rounded lg:text-left text-center"
                  href="{{route('view-article',
                    ['category' =>
                    $latestActivity instanceof \App\Models\Article ? $latestActivity->category
                    : $latestActivity->article->category,
                    'article' => $latestActivity instanceof \App\Models\Article ? $latestActivity
                    : $latestActivity->article,
                    'id' => $latestActivity instanceof \App\Models\Article ? $latestActivity->id
                    : $latestActivity->article->id])}}">
                  <div class="avatar lg:pr-2 pr-0">
                    <div class="w-12 h-12 rounded-full">
                      <img alt="user avatar"
                           src="{{asset('storage/'.$latestActivity->user->avatar)}}"/>
                    </div>
                  </div>
                  <div class="flex-col pl-2">
                    <b>{{$latestActivity->user->username}}</b>
                    <p>Wrote At: {{$latestActivity->created_at}}</p>
                  </div>
                </a>
              @else
                <a class="lg:flex w-3/6 p-2 transition hover:bg-gray-300/10 duration-300 rounded text-center" href="#">
                  <div class="pl-2">
                    <b>No Recent Activity</b>
                  </div>
                </a>
              @endif
            </div>
            <div class="divider divider-vertical m-0 pb-4"></div>
          @endif
        @endforeach
      @endforeach
    </x-layout.card>
  </div>
</x-app-layout>
