<x-app-layout>
    <x-slot name="header">
        <x-sidebar/>
    </x-slot>
    <div class="flex space-x-4 p-4 justify-center">
        <x-white-card class="w-screen">
            <form method="post" action="{{route('update-profile')}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="flex xs:flex-row flex-col xs:space-x-8 space-x-0 justify-center">
                    <div class="flex flex-col">
                        {{-- First Name --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 bg-gradient-to-r from-primary-content"
                               for="first_name">First name</label>
                        <input type="text"
                               id="first_name"
                               name="first_name"
                               placeholder="Your first name"
                               class="input text-lg input-bordered input-primary w-full max-w-xs m-1"
                               value="{{auth()->user()->first_name}}"
                        />
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        {{-- Last Name --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 bg-gradient-to-r from-primary-content"
                               for="last_name">Last name</label>
                        <input type="text"
                               id="last_name"
                               name="last_name"
                               placeholder="Your last name"
                               class="input text-lg input-bordered input-primary w-full max-w-xs m-1"
                               value="{{auth()->user()->last_name}}"
                        />
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        {{-- Username --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 bg-gradient-to-r from-primary-content"
                               for="username">Username</label>
                        <input type="text"
                               id="username"
                               name="username"
                               placeholder="username"
                               class="input text-lg input-bordered input-primary w-full max-w-xs m-1"
                               value="{{auth()->user()->username}}"
                        />
                        @error('username')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        <small class="font-sans italic pl-1 ml-1">
                            * Can be changed only <u>once</u> a month!</small>
                        {{-- Email --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 bg-gradient-to-r from-primary-content"
                               for="email">Email</label>
                        <input type="text"
                               id="email"
                               name="email"
                               placeholder="something@somewhere.domain"
                               class="input text-lg input-bordered input-primary w-full max-w-xs m-1"
                               value="{{auth()->user()->email}}"
                        />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        {{-- Old password --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 bg-gradient-to-r from-primary-content"
                               for="oldPassword">Change password</label>
                        <input type="text"
                               id="oldPassword"
                               name="oldPassword"
                               placeholder="Enter old password"
                               class="input text-lg input-bordered input-primary w-full max-w-xs m-1"
                               value=""
                        />
                        {{-- Password --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 hidden" id="password-label"
                               for="password">New password</label>
                        <input type="text"
                               id="password"
                               name="password"
                               placeholder="Enter new password"
                               class="input text-lg input-bordered input-primary w-full max-w-xs m-1 hidden"
                               value=""
                        />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        {{-- Password confirmation--}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 hidden" id="password-confirmation-label"
                               for="password_confirmation">Re-enter password</label>
                        <input type="text"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Enter new password again"
                               class="input text-lg input-bordered input-primary w-full max-w-xs m-1 hidden"
                               value=""
                        />
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        <script>
                            document.querySelector('input[name="oldPassword"]').addEventListener('input', function () {
                                document.querySelector('input[name="password"]').classList.remove('hidden');
                                document.querySelector('input[name="password_confirmation"]').classList.remove('hidden');
                                document.getElementById('password-label').classList.remove('hidden');
                                document.getElementById('password-confirmation-label').classList.remove('hidden');
                            }, {once : true});
                        </script>
                    </div>
                    <div class="flex flex-col">
                        {{-- Avatar --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 bg-gradient-to-r from-primary-content">Profile picture</label>
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
                        <label class="block">
                            <span class="sr-only">Choose Image</span>
                            <input type="file"
                                   id="file-input"
                                   class="block p-1 mt-4 w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4 file:rounded-5
                                          file:border-0 file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   name="avatar"
                                   accept="image/png, image/jpeg"
                            />
                        </label>
                        <small id="file-warning" class="font-sans text-red-600 italic pl-1 ml-1 hidden">
                            * Please use files no larger than 2MB!</small>
                        <script>
                            let fileInput = document.getElementById('file-input');
                            let warning = document.getElementById('file-warning');
                            fileInput.addEventListener('change', function () {
                                if (fileInput.files.length > 0) {
                                    const fileSize = fileInput.files.item(0).size;
                                    const fileMb = fileSize / 1024 ** 2;
                                    if (fileMb >= 2) {
                                        warning.classList.remove('hidden');
                                    } else {
                                        warning.classList.add('hidden');
                                    }
                                }
                            });
                        </script>
                        @error('avatar')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        {{-- Bio --}}
                        <label class="font-bold uppercase p-2 ml-1 mt-4 bg-gradient-to-r from-primary-content">Bio</label>
                        <div class="p-1">
                            <input id="x" type="hidden" name="bio" value="{{auth()->user()->bio}}"/>
                            <trix-editor input="x" class="trix-content max-h-40 overflow-auto">
                                <script src="{{ asset('js/trix.js') }}"></script>
                            </trix-editor>
                        </div>
                        @error('bio')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                        @enderror
                        {{-- Submit --}}
                        <button type="submit"
                                class="btn-sm btn-accent mt-4 ml-1 w-24">
                        Save</button>
                    </div>
                </div>
            </form>
        </x-white-card>
    </div>
</x-app-layout>
