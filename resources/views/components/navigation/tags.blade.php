@props(['tagsCsv'])
@php($tags = explode(',', $tagsCsv))
<ul class="sm:flex">
  @foreach($tags as $tag)
  <li class="badge badge-lg badge-secondary rounded mx-2 mt-4 p-2">
    <a href="/?tag={{$tag}}" class="flex">
      <small class="mr-2">•</small>{{$tag}}
    </a>
  </li>
  @endforeach
</ul>
