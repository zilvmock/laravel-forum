<x-app-layout>
  <div class="md:m-4 md:p-2 mt-2 md:w-9/12">
    <x-navigation.recent-articles :latestArticles="$latestArticles"/>
    <x-layout.card class="rounded-none rounded-t md:rounded">
      <x-layout.top-bar>
        <x-slot:title>
          <h1 class="col-start-2 text-lg font-bold m-0">{{$categoryData['title']}}</h1>
        </x-slot:title>
        <x-slot:button>
          <form action="{{route('create_article', $categoryData['id'])}}" method="post">
            @csrf
            @method('GET')
            <button class="btn btn-sm btn-primary p-2 mx-2 h-full">Create New</button>
          </form>
        </x-slot:button>
      </x-layout.top-bar>
      @if(count($articleData) == 0)
        <div class="badge badge-info gap-2 sm:m-4 p-4 mt-2">
          <x-icons.daisy.info-circle/>
          No Articles
        </div>
      @else
        @foreach($articleData as $article)
          <div class="md:flex items-center">
            <div class="grid pt-4 grid-cols-1 grid-rows-2 px-4 items-center place-items-center">
              <div class="row-start-1">
                <x-icons.heroicons.chat-bubbles class="w-12"/>
              </div>
              <div class="row-start-2">
                {{-- Admin Controls --}}
                @if(auth()->user()->role == 1)
                  <div class="flex items-center">
                    <x-layout.modal-button :elIdName="$article['id'].'A'">
                      <x-icons.heroicons.trash/>
                    </x-layout.modal-button>
                  </div>
                  <x-layout.modal :title="'Delete Article'" :elId="$article['id']"
                                  :elIdName="$article['id'].'A'"
                                  :route="'delete_article_admin'">
                    <x-slot:text>
                      Are you sure you want to delete this article?<br>
                      <b class="text-error">All data associated with this article (like comments) will be deleted as
                        well!</b><br>
                      Click <b>YES</b> to confirm, <b>NO</b> to cancel.
                    </x-slot:text>
                  </x-layout.modal>
                @endif
              </div>
            </div>
            <div class="divider divider-horizontal m-0 mr-2"></div>
            <div class="flex flex-col w-full pb-2 pr-4 ml-2">
              <a class="link link-hover font-bold text-secondary text-xl"
                 href="{{route('view_article', ['category' => $categoryData['slug'], 'article' => $article['slug'], 'id' => $article['id']])}}">
                {{$article['title']}}
              </a>
              <div class="flex">
                <p>{!!$article['contentSnippet']!!}</p>
              </div>
              <x-navigation.tags :tagsCsv="$article['tags']"/>
            </div>
            {{-- Latest comment (or author) in that article --}}
            <a
              class="w-full sm:w-3/6 p-2 flex xs:flex md:flex-col xl:flex-row xl:text-left text-left md:text-center justify-left items-center transition hover:bg-gray-300/10 duration-300 rounded"
              href="{{route('view_article', ['category' => $categoryData['slug'], 'article' => $article['slug'], 'id' =>  $article['id']])}}">
              <div class="avatar lg:pr-2 pr-0">
                <div class="w-12 h-12 rounded-full">
                  <img alt="user avatar" src="{{asset('storage/'.$article['latestActivity']->user->avatar)}}"/>
                </div>
              </div>
              <div class="flex-col pl-2 break-all">
                <b>{{$article['latestActivity']->user->username}}</b>
                <p>{{$article['latestActivity']->created_at}}</p>
              </div>
            </a>
          </div>
          <div class="divider divider-vertical m-0 pb-4"></div>
        @endforeach
      @endif
      {{-- Pagination --}}
      @if($articleData->hasPages())
        <div class="my-4 bg-secondary/10 rounded p-1 mx-12">
          {{ $articleData->links()}}
        </div>
      @endif
    </x-layout.card>
  </div>
</x-app-layout>
