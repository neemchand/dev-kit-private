<x-app-layout>
    <x-slot name="header">
        {{ __('misc.user') }}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('misc.create_user') }}
                            </h2>
                        </header>

                        <form method="post" action="{{ route('admin.users.store') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('post')

                            <div>
                                <x-input-label for="first_name" :value="__('misc.first_name')"/>
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                                              :value="old('first_name')" required autofocus autocomplete="first_name"/>
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
                            </div>

                            <div>
                                <x-input-label for="last_name" :value="__('misc.last_name')"/>
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                              :value="old('last_name')" required autocomplete="last_name"/>
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('auth.email_field')"/>
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                              :value="old('email')" required autocomplete="username"/>
                                <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('auth.password_field')" />

                                <x-text-input id="password" class="block mt-1 w-full"
                                              type="password"
                                              name="password"
                                              required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('auth.confirm_password_field')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                              type="password"
                                              name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div>
                                <fieldset>
                                    <legend class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-200">Roles</legend>
                                    <div class="mt-4 divide-y divide-gray-200 dark:divide-gray-600 border-b border-t border-gray-200 dark:border-gray-600">
                                        @foreach($roles as $i => $role)
                                            <div class="relative flex items-start py-2">
                                                <div class="min-w-0 flex-1 text-sm leading-6">
                                                    <label for="role-{{$i}}"
                                                           class="select-none font-medium text-gray-900 dark:text-gray-300">{{$role}}</label>
                                                </div>
                                                <div class="ml-3 flex h-6 items-center">
                                                    <input id="role-{{$i}}" name="role[{{$i}}]" type="checkbox" value="{{$role}}"
                                                           {{ (is_array(old('role')) and in_array($role, old('role'))) ? ' checked' : '' }}
                                                           class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-orange-600 shadow-sm focus:ring-orange-500 dark:focus:ring-orange-600 dark:focus:ring-offset-gray-800">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('role.*')
                                    <x-input-error class="mt-2" :messages="$message"/>
                                    @enderror
                                </fieldset>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('misc.save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
