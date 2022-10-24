@props(['tagsCsv'])
@php($tags = explode(',', $tagsCsv))
<ul class="m-0">
  @foreach($tags as $tag)
    <li class="badge badge-lg badge-secondary rounded mr-2 mt-4 p-2">
      <a href="#" {{--href="/?tag={{$tag}}" --}} class="flex">
        <small class="mr-2">•</small>{{$tag}}
      </a>
    </li>
  @endforeach
</ul>
