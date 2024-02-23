<x-app-layout>
    <x-slot name="header">
        {{ __('misc.activity_log') }}
    </x-slot>

    <div class="py-4">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">Logs</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all activity logs on models and
                        more.</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <x-th-sortable title="{{ __('misc.when') }}" field="id"></x-th-sortable>
                                    <th scope="col"
                                        class="sm:pl-6 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-300">
                                        {{ __('misc.description') }}
                                    </th>
                                    <th scope="col"
                                        class="sm:pl-6 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-300">
                                        {{ __('misc.causer_type') }}
                                    </th>
                                    <x-th-sortable title="{{ __('misc.causer') }}" field="causer_id"></x-th-sortable>
                                    <th scope="col"
                                        class="sm:pl-6 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-300">
                                        {{ __('misc.subject_type') }}
                                    </th>
                                    <x-th-sortable title="{{ __('misc.subject') }}" field="subject_id"></x-th-sortable>
                                    <th scope="col"
                                        class="sm:pl-6 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-300">
                                        {{ __('misc.properties') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach ($activities as $activity)
                                    <tr class="even:bg-gray-50 dark:even:bg-gray-900">
                                        <td class="whitespace-nowrap px-2 py-2 text-xs text-gray-500 dark:text-gray-200 sm:pl-6">
                                            {{ $activity->created_at }}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500 dark:text-gray-200 sm:pl-6">
                                            {{ $activity->description }}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500 dark:text-gray-200 sm:pl-6">
                                            @if($activity->causer_type)
                                                {{basename(str_replace('\\', '/', $activity->causer_type))}}
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500 dark:text-gray-200 sm:pl-6">
                                            @if($activity->causer)
                                                {{$activity->causer->id ?? '' }}
                                                <i class="text-xs text-gray-400 dark:text-gray-500">
                                                    {{$activity->causer->email ?? $activity->causer->name ?? '' }}
                                                </i>
                                            @elseif($activity->causer_id)
                                                {{$activity->causer_id}}
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500 dark:text-gray-200 sm:pl-6">
                                            @if($activity->subject_type)
                                                {{basename(str_replace('\\', '/', $activity->subject_type))}}
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500 dark:text-gray-200 sm:pl-6">
                                            @if($activity->subject)
                                                {{$activity->subject->id ?? '' }}
                                                <i class="text-xs text-gray-400 dark:text-gray-500">
                                                    {{$activity->subject->email ?? $activity->subject->name ?? '' }}
                                                </i>
                                            @elseif($activity->subject_id)
                                                {{$activity->subject_id}}
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-xs text-gray-500 dark:text-gray-200 sm:pl-6">
                                            @php
                                                $collection1 = collect($activity->changes['old'] ?? []);
                                                $collection2 = collect($activity->changes['attributes'] ?? []);
                                            @endphp
                                            @if($collection1->isNotEmpty() and $collection2->isNotEmpty())
                                                @foreach($collection1 as $key => $value)
                                                    <b>{{$key}}:</b> {{$value}} -> {{$collection2[$key] ?? ''}}<br>
                                                @endforeach
                                            @elseif($collection1->isEmpty() and $collection2->isEmpty() and $activity->properties)
                                                @foreach($activity->properties as $key => $value)
                                                    <b>{{$key}}:</b> {!! json_encode($value) !!} <br>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
