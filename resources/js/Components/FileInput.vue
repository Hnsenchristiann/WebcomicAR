<template>
    <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                {{label}}
            </label>
        </div>
        <div class="md:w-2/3">
            <input :value="value" @input="$emit('input', $event.target.value)" class="bg-gray-300 appearance-none border rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="file">
        </div>
    </div>  
</template>

<script>
export default {
    name: 'file-input-component',
    props: ['label', 'value'],
}
</script>

<style scoped>

</style>