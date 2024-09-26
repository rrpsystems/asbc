<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 dark:text-gray-400">

    <thead class="text-white bg-sky-800 dark:bg-sky-950 dark:text-gray-400">
        <tr>
            {{ $header ?? '' }}
        </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
        {{ $body ?? '' }}
    </tbody>

</table>
