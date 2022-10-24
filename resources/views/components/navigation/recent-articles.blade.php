@props(['latestArticles'])

{{-- Recent Articles --}}
<x-layout.card {{ $attributes->merge(['class' => 'mb-4 w-full']) }}>
  <x-layout.card class="text-center bg-secondary/10 mb-2">
    <h1 class="text-lg font-bold m-0">Recent Articles</h1>
  </x-layout.card>
  <div class="md:flex justify-center rounded">
    @if($latestArticles != null)
      <div class="divider divider-horizontal px-4"></div>
      @foreach($latestArticles as $article)
        <div class="flex-col md:pl-0 pl-2">
          <a class="link link-hover font-bold text-secondary text-md"
             href="{{route('view_article', [
                'category' => $article->category->slug,
                'article' => $article->slug,
                'id' => $article->id])}}">
            {!! $article->title !!}
          </a>
          <p class="text-xs"><b>By: {{$article->user->username}}</b><br>
            <small>{{$article->created_at}}</small>
          </p>
        </div>
        <div class="divider md:divider-horizontal px-4"></div>
      @endforeach
    @else
      <p>No recent articles</p>
    @endif
  </div>
</x-layout.card>
