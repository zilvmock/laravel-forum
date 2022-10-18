@php
  use App\Models\Article as Article;
      $latestArticle = Article::all()->sortByDesc('created_at')->first();
@endphp

{{-- Recent Articles --}}
<x-layout.card {{ $attributes->merge(['class' => 'sm:m-4 p-4 mt-2 h-max w-auto lg:w-1/4 order-last']) }}>
  <x-layout.card class="text-center bg-secondary/10 mb-2">
    <h1 class="text-lg font-bold">Recent Articles</h1>
  </x-layout.card>
  <div class="divider m-0"></div>
  <div class="rounded sm:w-full">
    @if($latestArticle != null)
      <a class="link link-hover font-bold text-secondary text-md"
         href="{{route('view-article', [
                'category' => $latestArticle->category,
                'article' => $latestArticle,
                'id' => $latestArticle->id])}}">
        {{$latestArticle->title}}
      </a>
      <p><b>By: {{$latestArticle->user->username}}</b><br>
        <small><i>{{$latestArticle->created_at->format('Y M d, h:i')}}</i></small>
      </p>
    @else
      <p>No recent articles</p>
    @endif
  </div>
</x-layout.card>
