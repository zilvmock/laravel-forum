<x-app-layout>
  <div class="md:m-4 md:p-2 mt-2 md:w-9/12">
    <x-layout.card class="rounded-none rounded-t md:rounded">
      <x-layout.top-bar>
        <x-slot:title>
          <h1 class="text-lg font-bold m-0">Edit Article</h1>
        </x-slot:title>
      </x-layout.top-bar>
      <form action="{{route('update_article', $article->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- Title --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Title</x-input.input-label>
          <x-input.text-input class="w-full text-center" maxlength="100" name="title"
                              value="{{old('title', $article->title)}}"/>
          <x-input.input-label class="text-md pl-1">* Try to keep it short and specific</x-input.input-label>
          @error('title')
          <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
          @enderror
        </div>
        {{-- Article --}}
        <x-input.editor-with-timeout>
          <div class="bg-secondary/10 rounded mt-4 p-4 text-center">
            <x-input.input-label class="text-lg pl-1">Content</x-input.input-label>
            <x-tinymce.head.tinymce-config :image="'image'"/>
            <x-tinymce.forms.tinymce-editor :name="'article_content'">
              {{old('article_content', $article->content)}}
            </x-tinymce.forms.tinymce-editor>
            @error('article_content')
            <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
            @enderror
          </div>
        </x-input.editor-with-timeout>
        {{-- Tags --}}
        <div class="bg-secondary/10 rounded p-4 mt-4 text-center">
          <x-input.input-label class="text-lg pl-1">Tags</x-input.input-label>
          <x-input.text-input class="w-full text-center" maxlength="100" name="tags"
                              value="{{old('tags', $article->tags)}}"/>
          <x-input.input-label class="text-md pl-1">* Separate tags with comma (,)</x-input.input-label>
          @error('tags')
          <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
          @enderror
        </div>
        <x-input.primary-button class="m-2">Update Article</x-input.primary-button>
        <button class="btn btn-sm btn-ghost bg-error m-2" type="reset"><a href="{{route('browse')}}">Cancel</a></button>
      </form>
    </x-layout.card>
  </div>
</x-app-layout>
