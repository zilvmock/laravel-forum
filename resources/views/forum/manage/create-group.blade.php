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
          <h1 class="text-lg font-bold">Create Group</h1>
        </div>
      </x-layout.card>
      <form action="{{route('store_group')}}" method="post">
        @method('PUT')
        @csrf
        {{-- Group Title --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Group Title</x-input.input-label>
          <x-input.text-input class="w-full text-center" maxlength="100" name="title" value="{{old('title')}}"/>
          <x-input.input-label class="text-md pl-1">* Try to keep it short and specific</x-input.input-label>
          @error('title')
          <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
          @enderror
        </div>
        {{-- Group Categories --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Group Categories</x-input.input-label>
          <x-input.input-label class="text-md pl-1 mb-4">
            All available categories. Disabled (darker ones) are in this group already.
            <u>Categories <b>cannot</b> be unassigned from group, only added to one.</u>
          </x-input.input-label>
          @if($categories->isNotEmpty())
            <div class="text-left">
              <table class="table-fixed overflow-y-scroll">
                <thead class="bg-base-300">
                <tr>
                  <th>
                  </th>
                  <th class="py-2 pr-6 pl-4 ml-2">Category Title</th>
                  <th class="py-2 pr-6 pl-0 ml-2 ml-2">Number of Articles</th>
                  <th class="py-2 pr-6 pl-0 ml-2 ml-2">Number of Comments</th>
                </tr>
                </thead>
                <tbody class="bg-base-100">
                @foreach($categories as $category)
                  <tr class="border-b border-secondary/10">
                    <th>
                      <label>
                        <input id="{{$category->id}}" type="checkbox" class="checkbox checkbox-xs p-2 ml-2"/>
                      </label>
                    </th>
                    <td class="py-2 pr-6 pl-2">
                      <div>
                        <div class="font-bold py-1 ml-2">{{$category->title}}</div>
                        <div class="text-sm opacity-50 ml-2">{{substr($category->description, 0, 50)}}...</div>
                      </div>
                    </td>
                    @php
                      $category_articles = $articles->where('category_id', '=', $category->id);
                      $category_comment_count = 0;
                        foreach ($category_articles as $article) {
                            $category_comment_count += count($comments->where('article_id', '=', $article->id));
                        }
                    @endphp
                    <td>{{count($category_articles)}}</td>
                    <td>{{$category_comment_count}}</td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot class="bg-base-300">
                <tr>
                  <th></th>
                  <th class="py-2 pr-6 pl-4 ml-2">Category Title</th>
                  <th class="py-2 pr-6 pl-0 ml-2 ml-2">Number of Articles</th>
                  <th class="py-2 pr-6 pl-0 ml-2 ml-2">Number of Comments</th>
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
            document.getElementById('category_ids').value = ids;
          }
        </script>
        @else
          <p class="py-4">No Categories Found</p>
        @endif
        <input id="category_ids" type="text" class="hidden" name="category_ids" value=""/>
        <x-input.primary-button class="m-2" onclick="getChecked()">Create Group</x-input.primary-button>
        <button class="btn btn-sm btn-ghost bg-error m-2" type="reset"><a href="{{route('browse')}}">Cancel</a></button>
      </form>
    </x-layout.card>
  </div>
</x-app-layout>
