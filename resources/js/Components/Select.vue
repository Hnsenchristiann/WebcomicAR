

<template>
    <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                {{label}}
            </label>
        </div>
        <div class="md:w-2/3">
            <select :value="value" @input="$emit('input', $event.target.value)" class="w-full h-10 pl-3 pr-6 text-base bg-gray-300 border rounded-lg appearance-none focus:shadow-outline" placeholder="Regular input">
                <option v-for="(item, idx) in items" :key="idx" :value="item.value">{{item.label}}</option>
            </select>
        </div>
    </div>  
</template>

<script>
export default {
    name: 'select-component',
    props: ['label', 'value', 'items'],
}
</script>

<style scoped>

</style>