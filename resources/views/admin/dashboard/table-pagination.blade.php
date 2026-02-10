<div class="flex justify-between items-center text-sm p-4 dark:bg-gray-800">
    <span class="text-gray-500">
        Page <span x-text="page"></span> of <span x-text="pages"></span>
    </span>

    <div class="flex gap-1">
        <button
            @click="page > 1 && page--"
            :disabled="page === 1"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest
            hover:bg-gray-700 dark:hover:bg-white
            focus:bg-gray-700 dark:focus:bg-white
            active:bg-gray-900 dark:active:bg-gray-300
            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
            transition ease-in-out duration-150
            disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Prev
        </button>

        <template x-for="p in pages" :key="p">
            <button
                @click="page = p"
                class="px-3 py-1 rounded"
                :class="page === p ? 'bg-blue-600 text-white' : 'bg-gray-200'"
                x-text="p"
            ></button>
        </template>

        <button
            @click="page < pages && page++"
            :disabled="page === pages"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest
            hover:bg-gray-700 dark:hover:bg-white
            focus:bg-gray-700 dark:focus:bg-white
            active:bg-gray-900 dark:active:bg-gray-300
            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800
            transition ease-in-out duration-150
            disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Next
        </button>
    </div>
</div>