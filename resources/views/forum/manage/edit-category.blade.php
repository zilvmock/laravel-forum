<x-app-layout>
  <div class="sm:m-4 sm:p-4 mt-2">
    <x-layout.card>
      <x-layout.card class="flex justify-between overflow-hidden bg-secondary/10 mb-2">
        <div class="flex">
          <button class="mr-6 btn btn-sm btn-ghost w-max">
            <a href="{{url()->previous()}}">
              <x-icons.heroicons.arrow-uturn-left/>
            </a>
          </button>
          <h1 class="text-lg font-bold">Update Category</h1>
        </div>
      </x-layout.card>
      <form action="{{route('update_category', $category->id)}}" method="post">
        @method('PUT')
        @csrf
        {{-- Category Title --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Category Title</x-input.input-label>
          <x-input.text-input class="w-full text-center" maxlength="100" name="title"
                              value="{{old('title', $category->title)}}"/>
          <x-input.input-label class="text-md pl-1">* Try to keep it short and specific</x-input.input-label>
          @error('title')
          <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
          @enderror
        </div>
        {{-- Category Description --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Category Description</x-input.input-label>
          <x-input.text-input class="w-full text-center" maxlength="150" name="description"
                              value="{{old('description', $category->description)}}"/>
          <x-input.input-label class="text-md pl-1">* Try to keep it short and specific</x-input.input-label>
          @error('description')
          <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
          @enderror
        </div>
        {{-- Category Articles --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Category Articles</x-input.input-label>
          <x-input.input-label class="text-md pl-1 mb-4">
            All available articles. Disabled (darker ones) are in this category already.
            <u>Articles <b>cannot</b> be unassigned from category, only added to one.</u>
          </x-input.input-label>
          @if($articles->isNotEmpty())
            <div class="text-left">
              <table class="table-fixed overflow-y-scroll">
                <thead class="bg-base-300">
                <tr>
                  <th>
                  </th>
                  <th class="py-2 pr-6 pl-4 ml-2">Article</th>
                  <th class="py-2 pr-6 pl-2 ml-2 ml-2">Current Category Title of Article</th>
                  <th class="py-2 pr-6 pl-2 ml-2 ml-2">Number of Comments In Article</th>
                </tr>
                </thead>
                <tbody class="bg-base-100">
                @foreach($articles as $article)
                  <tr
                    class="{{$categoryArticles->contains($article->id) ? 'bg-gray-400/5':''}} border-b border-secondary/10">
                    <th>
                      <label>
                        <input id="{{$article->id}}"
                               {{$categoryArticles->contains($article->id) ? 'disabled checked':''}} type="checkbox"
                               class="checkbox checkbox-xs p-2 ml-2"/>
                      </label>
                    </th>
                    <td class="py-2 pr-6 pl-2">
                      <div class="font-bold py-1 ml-2">{{$article->title}}</div>
                      <div class="text-sm opacity-50 ml-2">{!!substr($article->content, 0, 50)!!}...</div>
                    </td>
                    <td class="px-2">{{$article->category->title}}</td>
                    <td class="px-2">{{count($comments->where('article_id', '=', $article->id))}}</td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot class="bg-base-300">
                <tr>
                  <th></th>
                  <th class="py-2 pr-6 pl-4 ml-2">Article</th>
                  <th class="py-2 pr-6 pl-2 ml-2 ml-2">Current Category Title of Article</th>
                  <th class="py-2 pr-6 pl-2 ml-2 ml-2">Number of Comments In Article</th>
                </tr>
                </tfoot>
              </table>
            </div>
        </div>
        <script>
          function getChecked() {
            var ids = []
            let checked = document.querySelectorAll('input[type=checkbox]:checked')
            for (var i = 0; i < checked.length; i++) {
              ids.push(checked[i].id);
            }
            document.getElementById('article_ids').value = ids;
          }
        </script>
        @else
          <p class="py-4">No Articles Found</p>
        @endif
        <input id="article_ids" type="text" class="hidden" name="article_ids" value=""/>
        <x-input.primary-button class="m-2" onclick="getChecked()">Update Category</x-input.primary-button>
        <button class="btn btn-sm btn-ghost bg-error m-2" type="reset"><a href="{{route('browse')}}">Cancel</a></button>
      </form>
    </x-layout.card>
  </div>
</x-app-layout>
