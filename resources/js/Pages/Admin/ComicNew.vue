<template>
    <div>
        <div class="w-full max-w-lg p-4 mb-4 bg-gray-200 rounded">
            <div>Comic Details</div>
            <input-component label="Title" v-model="title"></input-component>
            <input-component label="Description" v-model="description"></input-component>
            <input-component label="Tags" v-model="tags" placeholder="Separated by comma"></input-component>
            <input-component label="Genres" v-model="genres" placeholder="Separated by comma"></input-component>
            <input-component label="Price" v-model="price"></input-component>
            <file-input-component label="Cover Image" v-model="cover_url"></file-input-component>
            <select-component label="Author" v-model="author" :items="authors"></select-component>
        </div>
        <div class="w-full max-w-lg p-4 mb-4 bg-gray-200 rounded">
            <div class="flex justify-between">
                <div>
                    Pages
                </div>
                <button @click="addPage" class="mb-4 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-1 px-2 border border-blue-500 hover:border-transparent rounded">
                    Add New Page
                </button>
            </div>
            <div v-for="(page, idx) in pages" :key="'container' + idx" class="mb-2 border-2 border-gray-300 rounded p-2 rounded">
                <input-component label="Page number" v-model="page.page_number" :key="'pageNumber' + idx"></input-component>
                <file-input-component label="Page image" v-model="page.image_url" :key="'image' + idx"></file-input-component>
                <textarea-component label="Config" v-model="page.config" :key="'config' + idx"></textarea-component>
            </div>
        </div>
        <button @click="submit" class="mb-4 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            Submit
        </button>
    </div>
</template>

<script>
import InputComponent from '../../Components/Input.vue'
import SelectComponent from '../../Components/Select.vue'
import FileInputComponent from '../../Components/FileInput.vue'
import TextareaComponent from '../../Components/Textarea.vue'
export default {
    name: 'comic-new',
    components: {
        InputComponent,
        FileInputComponent,
        SelectComponent,
        TextareaComponent
    },
    created(){
        axios.get(route('api.authors.list'))
        .then((response) => {
            this.authors = response.data.map((element, index) => {
                return {
                    label: element.name,
                    value: element.id
                }
            })
        })
    },
    methods: {
        submit(){
            
        },
        addPage(){
            this.pages.push(
                {
                    page_number: 1,
                    image_url: null,
                    config: ''
                }
            )
        }
    },
    data(){
        return {
            authors: [],
            pages: [],
            title: '',
            description: '',
            tags: '',
            genres: '',
            author: null,
            price: 0,
            cover_url: null,
            pages: [
                {
                    page_number: 1,
                    image_url: null,
                    config: ''
                }
            ],
        }
    }
}
</script>