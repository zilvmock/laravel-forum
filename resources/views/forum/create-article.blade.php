<x-app-layout>
  <x-layout.card class="m-4 p-4 w-full sm:w-fit md:w-fit lg:w-9/12 xl:w-10/12">
    <x-layout.card class="flex justify-between overflow-hidden bg-secondary/10 mb-2">
      <div class="flex">
        <button class="mr-6 btn btn-sm btn-ghost w-max">
          <a href="{{url()->previous()}}">
            <x-icons.heroicons.arrow-uturn-left/>
          </a>
        </button>
        <h1 class="text-lg font-bold">Write New Article</h1>
      </div>
    </x-layout.card>
    <form action="{{route('store-article')}}" method="post" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      {{-- Title --}}
      <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
        <x-input.input-label class="text-lg pl-1">Title</x-input.input-label>
        <x-input.text-input class="w-full text-center" maxlength="100" name="title" value="{{old('title')}}"/>
        <x-input.input-label class="text-md pl-1">* Try to keep it short and specific</x-input.input-label>
        @error('title')
        <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
        @enderror
      </div>
      {{-- Article --}}
      <div class="bg-secondary/10 rounded mt-4 p-4">
        <x-input.input-label class="text-lg pl-1">Content</x-input.input-label>
        <x-tinymce.head.tinymce-config :image="'image'"/>
        <x-tinymce.forms.tinymce-editor :name="'article_content'">
          {{old('article_content')}}
        </x-tinymce.forms.tinymce-editor>
        @error('article_content')
        <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
        @enderror
      </div>
      {{-- Tags --}}
      <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
        <x-input.input-label class="text-lg pl-1">Tags</x-input.input-label>
        <x-input.text-input class="w-full text-center" maxlength="100" name="tags" value="{{old('tags')}}"/>
        <x-input.input-label class="text-md pl-1">* Separate tags with comma (,)</x-input.input-label>
        @error('tags')
        <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
        @enderror
      </div>
      {{-- Category --}}
      <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
        <x-input.input-label class="text-lg pl-1">Category</x-input.input-label>
        <input id="selected-category" name="categoryId" type="hidden" value=""/>
        <select id="category-selection" class="select select-secondary w-full" onchange="setCategorySelection(value)">
          <option disabled selected>Select Articles' Category</option>
          @foreach($categories as $category)
            <option id="{{$category->id}}">{{$category->title}}</option>
          @endforeach
        </select>
        <script>
          let oldVal = '{{old('categoryId')}}';
          if (oldVal !== '') {
            document.getElementById({{old('categoryId')}}).selected=true;
          }
        </script>
        @error('categoryId')
        <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
        @enderror
        <script>
          function setCategorySelection() {
            let options = document.getElementById('category-selection').options;
            document.getElementById('selected-category').value = options[options.selectedIndex].id;
          }
        </script>
      </div>
      <x-input.primary-button class="m-2">Post Article</x-input.primary-button>
      <button class="btn btn-sm btn-ghost bg-error m-2" type="reset"><a href="{{route('browse')}}">Cancel</a></button>
    </form>
  </x-layout.card>
</x-app-layout>
