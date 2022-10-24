<x-app-layout>
  <div class="md:m-4 md:p-2 mt-2 md:w-9/12">
    <x-layout.card class="rounded-none rounded-t md:rounded">
      <x-layout.top-bar>
        <x-slot:title>
          <h1 class="text-lg font-bold m-0">Edit Group</h1>
        </x-slot:title>
      </x-layout.top-bar>
      <form action="{{route('update_group', $groupId)}}" method="post">
        @method('PUT')
        @csrf
        {{-- Group Title --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Group Title</x-input.input-label>
          <x-input.text-input class="w-full text-center" maxlength="100" name="title"
                              value="{{old('title', $groupTitle)}}"/>
          <x-input.input-label class="text-sm pl-1">* Try to keep it short and specific</x-input.input-label>
          @error('title')
          <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
          @enderror
        </div>
        {{-- Group Categories --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Group Categories</x-input.input-label>
          <x-input.input-label class="text-sm pl-1 mb-4">
            All available categories. Disabled (darker ones) are in this group already.
            <u>Categories <b>cannot</b> be unassigned from group, only added to one.</u>
          </x-input.input-label>
          @if($categoryData != null)
            <div class="text-left flex justify-center">
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
                @foreach($categoryData as $category)
                  <tr
                    class="{{$groupCategories->contains($category['id']) ? 'bg-gray-400/5':''}} border-b border-secondary/10">
                    <th>
                      <label>
                        <input id="{{$category['id']}}"
                               {{$groupCategories->contains($category['id']) ? 'disabled checked':''}} type="checkbox"
                               class="checkbox checkbox-xs p-2 ml-2"/>
                      </label>
                    </th>
                    <td class="py-2 pr-6 pl-2">
                      <div>
                        <div class="font-bold py-1 ml-2">{{$category['title']}}</div>
                        <div class="text-sm opacity-50 ml-2">{{substr($category['description'], 0, 50)}}...</div>
                      </div>
                    </td>
                    <td>{{$category['articleAmount']}}</td>
                    <td>{{$category['commentAmount']}}</td>
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
          <p class="py-4">No Articles Found</p>
        @endif
        <input id="category_ids" type="text" class="hidden" name="category_ids" value=""/>
        <x-input.primary-button class="m-2" onclick="getChecked()">Update Group</x-input.primary-button>
        <button class="btn btn-sm btn-ghost bg-error m-2" type="reset"><a href="{{route('browse')}}">Cancel</a></button>
      </form>
    </x-layout.card>
  </div>
</x-app-layout>
