<x-app-layout>
  {{-- All Topics --}}
  <div class="lg:flex mb-16">
    <x-navigation.recent-articles/>
    <x-layout.card class="sm:m-4 p-4 mt-2">
      @foreach($groupNames as $groupName)
        <x-layout.card class="bg-secondary/10 mb-2">
          <h1 class="text-lg font-bold">{{$groupName->group_name}}</h1>
        </x-layout.card>
        @if(!$empty->contains($groupName->id))
          <div class="badge badge-info gap-2 p-4 m-4">
            <x-icons.daisy.info-circle/>
            No Categories In This Section
          </div>
        @endif
        @foreach($categories as $category)
          @if($category->group->group_name == $groupName->group_name)
            {{-- Category Info --}}
            <div class="flex rounded py-2">
              <div>
                <x-icons.heroicons.chat-bubbles class="w-12"/>
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
                // TODO fix/check this later
                    // Latest article from current category
                    $latestArticle = $articles->where('category_id', '==', $category->id)->sortByDesc('created_at')->first();
                    if ($latestArticle == null) {
                        $latestActivity = null;
                    } else {
                      // Latest comment in that article
                      $latestComment = $comments->where('article_id', '==', $latestArticle->id)->sortByDesc('created_at')->first();

                      // Find the latest activity
                      if (strtotime($latestArticle->created_at)>strtotime($latestComment->created_at)) {
                          $latestActivity = $latestArticle;
                      } else {
                           $latestActivity = $latestComment;
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
                    <p>Wrote At: {{$latestActivity->created_at->format('Y M d, h:i')}}</p>
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
