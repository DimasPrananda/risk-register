<div
    x-show="cardPages >= 1"
    class="flex justify-between items-center text-sm p-4 mt-4
        bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-md"
>
    <span class="text-gray-500 dark:text-gray-400">
        Page <span x-text="cardPage"></span> of <span x-text="cardPages"></span>
    </span>

    <div class="flex gap-2">
        <button
            @click="cardPage > 1 && cardPage--"
            :disabled="cardPage === 1"
            class="inline-flex items-center px-4 py-2
                bg-gray-800 dark:bg-gray-200
                rounded-md font-semibold text-xs uppercase
                text-white dark:text-gray-800
                disabled:opacity-50 disabled:cursor-not-allowed
                transition"
        >
            Prev
        </button>

        <template x-for="p in cardPages" :key="p">
            <button
                @click="cardPage = p"
                class="px-3 py-1 rounded"
                :class="cardPage === p ? 'bg-blue-600 text-white' : 'bg-gray-200'"
                x-text="p"
            ></button>
        </template>

        <button
            @click="cardPage < cardPages && cardPage++"
            :disabled="cardPage === cardPages"
            class="inline-flex items-center px-4 py-2
                bg-gray-800 dark:bg-gray-200
                rounded-md font-semibold text-xs uppercase
                text-white dark:text-gray-800
                disabled:opacity-50 disabled:cursor-not-allowed
                transition"
        >
            Next
        </button>
    </div>
</div>