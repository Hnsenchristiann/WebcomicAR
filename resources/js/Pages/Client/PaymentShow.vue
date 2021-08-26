<template>
    <div class="px-5 py-5">
        <div class="bg-white rounded-lg h-full">
            <div class="lg:px-5 lg:py-5">
                <div class="text-base px-3 mt-4 divide-y divide-black pb-4 lg:bg-gray-300 lg:rounded-lg">
                    <div class="text-center font-bold text-xl pt-4">
                        Transaction Details
                    </div>
                    <div class="mb-3">
                        <template v-for="(item, idx) in cartItems">
                            <div v-for="(cpt, idxCpt) in item.chapters" :key="'cart-' + idx + '-' + idxCpt" class="mb-2">
                                {{item.title}} Ep. {{cpt}}
                                <div class="float-right">
                                    Rp. {{(item.price).toLocaleString('id-ID')}}
                                </div>
                                <select class="ml-3 text-sm" v-model="arSelected[item.id + '-' + cpt]">
                                    <option class="text-sm" selected>No Ar</option>
                                    <option class="text-sm" :value="item.id + '-' + cpt">Ar</option>
                                </select>
                            </div>
                        </template>
                    </div>
                    <div>
                        Total Items
                        <div class="float-right">
                            Rp. {{(total).toLocaleString('id-ID')}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- <template v-for="(item, idx) in cartItems">
        <div v-for="(cpt, idxCpt) in item.chapters" :key="'cart-' + idx + '-' + idxCpt" class="mb-2">
            <div>
                {{item.title}} Ep. {{cpt}}
            </div>
            <input type="checkbox" v-model="arSelected[item.id + '-' + cpt]" :value="item.id + '-' + cpt"> Buy AR
        </div>
    </template> -->
        <div class="lg:px-5">
            <div class="divide-y lg:bg-gray-300 lg:rounded-lg lg:h-64">
                <div>
                    <div class="block uppercase text-gray-500 text-xs font-bold mb-2 px-4 lg:pt-2">
                        CARDHOLDER'S NAME
                        <input class="mt-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Input Your Cardholder Name">
                    </div>
                    <div class="block uppercase text-gray-500 text-xs font-bold mb-2 px-4">
                        CARD NUMBER
                        <input class="mt-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="number" type="text" placeholder="Input Your Card Number">
                    </div>

                    <div class="font-bold px-4 mt-5 text-xs">
                        <div class="float-right block uppercase text-gray-500 text-xs font-bold mb-2">
                            <div>CVC/CVV</div>
                            <input class="mt-2 shadow appearance-none border rounded w-20 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cvv" type="text" placeholder="CVC/CVV">
                        </div>
                        <div class="block uppercase text-gray-500 text-xs font-bold mb-5">
                            <div>EXP DATE</div>
                            <input class="mt-2 shadow appearance-none border rounded w-28 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exp_date" type="text" placeholder="Exp Card Date">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:px-5 lg:py-5">
            <div class="lg:bg-gray-300 lg:rounded-lg lg:mb-5 lg:h-40">
                <div class="font-bold text-lg text-center py-2">
                    Online Payment
                </div>
                <div class="px-5">
                    <div class="block uppercase text-gray-500 text-xs font-bold mb-2 mt-3">
                        Choose Your Payment
                    </div>
                    <div class="inline-block relative w-28">
                        <select class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option>OVO</option>
                            <option>GO-PAY</option>
                            <option>DANA</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full bg-indigo-900 h-16 text-white text-center font-bold rounded-lg mt-8">
                <div class="py-4" @click="submit">Pay Order</div>
            </div>
        </div>
        </div>
       
        <!-- <div>Choose Method:</div>
        <div>
            <div>Credit/Debit Card</div>
            <form>
                <div class="grid grid-cols-5 gap-x-4 gap-y-1">
                    <label for="name" class="col-span-2 text-right text-sm">Card Holder Name</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="name">
                    <label for="name" class="col-span-2 text-right text-sm">Card Number</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="cardNumber">
                    <label for="name" class="col-span-2 text-right text-sm">Expiration Date</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="expDate">
                    <label for="name" class="col-span-2 text-right text-sm">CCV Number</label>
                    <input type="text" class="col-span-3 bg-gray-300 appearance-none border-2 border-gray-300 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" name="ccv">
                </div>
            </form>
        </div>
        <div>
            <div>Online Payment</div>
            <div>[button] [button] [button] [button]</div>
        </div> -->
        <!-- <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-50 bg-gray-800 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="submit">Submit</button> -->
    </div>
</template>

<script>
import Modal from '../../Components/Modal.vue'
export default {
    name:'payment-page',
    components:{
        Modal
    },
    created(){
        let cart = JSON.parse(localStorage.getItem('cart'))
        this.comics = Object.keys(cart)
        console.log(this.comics)
        if(cart){
            axios.get(route('api.comics.list', {where_in_id: JSON.stringify(this.comics)}))
            .then((response) => {
                this.cartItems = response.data
                this.cartItems.forEach((el, idx) => {
                    this.cartItems[idx].chapters = cart[el.id]
                    this.total += this.cartItems[idx].price * this.cartItems[idx].chapters.length
                })
            })
        }
    },
    data(){
        return {
            cartItems: [],
            arSelected: {},
            modal: true,
            comics: [],
            total: 0,
        }
    },
    methods:{
        submit(){
            let arBought = []
            Object.keys(this.arSelected).map((el) => {
                if(this.arSelected[el]){
                    arBought.push(el)
                }
            })
            let sendObj = {}
            this.cartItems.forEach((el) => {
                sendObj[el.id] = el.chapters
            })
            axios.post(route('api.comics.purchase'), {
                comic_ids: JSON.stringify(sendObj),
                ar_bought: JSON.stringify(arBought),
            })
            .then((response) => {
                localStorage.removeItem('cart')
                eventBus.$emit('cartAddItem')
                this.$router.push({name: 'comicShow', params: {comicId: Object.keys(sendObj)[0]}})
            })
        }
    }
}
</script>

<style>

</style>
