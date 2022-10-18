<x-app-layout>
  <div class="grid place-items-center">
    <x-navigation.nav-tabs-profile/>
    <x-layout.card class="p-8 sm:mx-4 mx-0">
      <form method="post" action="{{route('update-profile')}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="flex xs:flex-row flex-col xs:space-x-8 space-x-0 justify-center">
          <div class="flex flex-col">
            {{-- First Name --}}
            <x-input.input-label for="first_name" class="font-bold">First Name</x-input.input-label>
            <x-input.text-input id="first_name"
                                type="text"
                                name="first_name"
                                placeholder="Your first name"
                                value="{{auth()->user()->first_name}}"
            />
            @error('first_name')
            <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
            @enderror
            {{-- Last Name --}}
            <x-input.input-label for="last_name" class="mt-6 font-bold">Last Name</x-input.input-label>
            <x-input.text-input id="last_name"
                                type="text"
                                name="last_name"
                                placeholder="Your last name"
                                value="{{auth()->user()->last_name}}"
            />
            @error('last_name')
            <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
            @enderror
            {{-- Username --}}
            <x-input.input-label for="username" class="mt-6 font-bold">Username</x-input.input-label>
            <x-input.text-input id="username"
                                type="text"
                                name="username"
                                placeholder="username"
                                value="{{auth()->user()->username}}"
            />
            @error('username')
            <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
            @enderror
            <small class="font-sans italic pl-1 ml-1">
              * Can be changed only <u>once</u> a week!</small>
            {{-- Email --}}
            <x-input.input-label for="email" class="mt-6 font-bold">Email</x-input.input-label>
            <x-input.text-input id="email"
                                type="text"
                                name="email"
                                placeholder="something@somewhere.domain"
                                value="{{auth()->user()->email}}"
            />
            @error('email')
            <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
            @enderror
            {{-- Change Password --}}
            <div class="collapse my-6">
              @if(session()->has('checked') && session()->get('checked'))
                <input type="checkbox" checked class="peer"/>
              @else
                <input type="checkbox" class="peer"/>
              @endif
              <div
                class="flex font-bold collapse-title bg-neutral text-gray-300 peer-checked:bg-neutral peer-checked:text-gray-300">
                Change Password
                <x-icons.heroicons.chevron-down/>
              </div>
              <div class="collapse-content bg-neutral text-gray-300 peer-checked:bg-neutral peer-checked:text-gray-300">
                <div class="divider m-0"></div>
                <small>All field must be filled and correct</small>
                {{-- Old password --}}
                <x-input.input-label for="oldPassword" class="mt-6 font-bold">Old Password</x-input.input-label>
                <x-input.text-input id="oldPassword"
                                    type="text"
                                    name="oldPassword"
                                    placeholder="Enter old password"
                />
                @error('oldPassword')
                <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
                @enderror
                {{-- Password --}}
                <x-input.input-label id="password-label"
                                     for="password"
                                     class="mt-6 font-bold">New password
                </x-input.input-label>
                <x-input.text-input id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Enter new password"
                />
                @error('password')
                <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
                @enderror
                {{-- Password confirmation --}}
                <x-input.input-label id="password-confirmation-label"
                                     for="password_confirmation"
                                     class="mt-6 font-bold">New password
                </x-input.input-label>
                <x-input.text-input id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Enter new password again"
                />
                @error('password_confirmation')
                <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
                @enderror
              </div>
            </div>
          </div>
          <div class="flex flex-col">
            {{-- Avatar --}}
            <x-input.input-label class="font-bold">Priofile Picture</x-input.input-label>
            <div class="avatars p-2">
              <div class="avatar m-2">
                <div class="w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                  <img alt="user avatar" src="{{auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar)
                                        : asset('storage/avatars/no-avatar.jpg')}}"/>
                </div>
              </div>
              <div class="avatar m-2">
                <div class="w-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                  <img alt="user avatar" src="{{auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar)
                                        : asset('storage/avatars/no-avatar.jpg')}}"/>
                </div>
              </div>
              <div class="avatar m-2">
                <div class="w-12 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                  <img alt="user avatar" src="{{auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar)
                                        : asset('storage/avatars/no-avatar.jpg')}}"/>
                </div>
              </div>
            </div>
            <x-input.input-file-button>
              <x-slot:name>avatar</x-slot:name>
            </x-input.input-file-button>
            {{-- Custom Error --}}
            <x-informative.error-message id="file-warning" class="py-2 mt-2 hidden">
              Please use files no larger than 2MB!
            </x-informative.error-message>
            @error('avatar')
            <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
            @enderror
            {{-- Bio --}}
            <x-input.input-label class="mt-6 font-bold">Bio</x-input.input-label>
            <x-tinymce.head.tinymce-config/>
            <x-tinymce.forms.tinymce-editor>
              <x-slot:name>bio</x-slot:name>
              {{auth()->user()->bio}}
            </x-tinymce.forms.tinymce-editor>
            @error('bio')
            <x-informative.error-message class="py-2 mt-2">{{$message}}</x-informative.error-message>
            @enderror
            {{-- Submit --}}
            <div class="sm:flex-row sm:flex justify-end">
              <x-input.primary-button class="btn-success mt-4 ml-1 sm:w-48">
                Save
              </x-input.primary-button>
              <x-input.primary-button class="btn-error mt-4 ml-1 sm:w-48"
                                      type="reset">
                <a href="{{route('profile')}}">Cancel</a>
              </x-input.primary-button>
            </div>
          </div>
        </div>
      </form>
    </x-layout.card>
  </div>
</x-app-layout>
