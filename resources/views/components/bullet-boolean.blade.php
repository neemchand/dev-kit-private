<div class="flex items-center justify-end gap-x-2 sm:justify-start">
    @if ($condition)
        <div
            class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
            <div class="h-1.5 w-1.5 rounded-full bg-current"></div>
        </div>
        <div class="hidden text-green-800 dark:text-green-500 sm:block">{{$success}}</div>
    @else
        <div
            class="flex-none rounded-full p-1 text-rose-400 bg-rose-400/10">
            <div class="h-1.5 w-1.5 rounded-full bg-current"></div>
        </div>
        <div class="hidden text-rose-800 dark:text-rose-500 sm:block">{{$fail}}</div>
    @endif
</div>
