<script setup>

import {onMounted, ref} from "vue"
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head  } from '@inertiajs/vue3';


const props = defineProps({
  invoices: {
    type: Object,
    default: () => ({}),
  },
  can: {
    type: Object,
    default: () => ({}),
  },
})

let invoices = ref([])
let searchInvoice = ref([])

onMounted(async () => {
    getInvoices()
});

const getInvoices = async () => {
    let response = await axios.get("/api/get_all_invoice")
    //console.log('response', response)
    invoices.value = response.data.invoices
}

const search = async () => {
    let response = await axios.get('/api/search_invoice?s=' + searchInvoice.value)
    console.log('response ', response.data)
    invoices.value = response.data.invoices
}

const newInvoice = async () => {
    let form = await axios.get('/api/create_invoice');
    console.log(
        'Response => ', form.data
    )
    router.push('/invoice/new')
}

const onShow = (id) => {
    console.log("Show id ", id)
    router.push('/invoice/show/'+id)
}


// const form = useForm();

const destroy = (id) => {
    if (confirm("Are you sure you want to Delete?")) {
        form.delete(route('invoices.destroy', id));
    }
}

const edit = (id) => {
    if (confirm("Are you sure you want to Edit?")) {
        form.edit(route('invoices.patch', id));
    }
}


</script>

<template>

    <BreezeAuthenticatedLayout>
    <Head title="Invoice" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoice
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex bg-gray-800 justify-between items=center p-5">
                        <div class="flex space-x-2 items-center text-white">
                            Invoice Settings Page! Here you can list, create, update or delete invoice!
                        </div>
                        <div class="flex space-x-2 items-center" v-if="can.create">
                            <a href="#" class="px-4 py-2 bg-green-500 uppercase text-white rounded focus:outline-none flex items-center"><span class="iconify mr-1" data-icon="gridicons:create" data-inline="false"></span> Create Invoice</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">Invoice #</th>
                                <th scope="col" class="py-3 px-6">First Name</th>
                                <th scope="col" class="py-3 px-6">Due Date</th>
                                <th v-if="can.edit || can.delete" scope="col" class="py-3 px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="invoice in invoices" :key="invoice.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td data-label="Title" class="py-4 px-6">
                                    {{ invoice.number }}
                                </td>
                                <td data-label="Title" class="py-4 px-6">
                                    {{ invoice.customer.firstname }}
                                </td>
                                <td data-label="Title" class="py-4 px-6">
                                    {{ invoice.due_Date }}
                                </td>
                                <td
                                    v-if="can.edit || can.delete"
                                    class="py-4 px-6 w-48"
                                >
                                    <div type="justify-start lg:justify-end" no-wrap>
                                        <BreezeButton class="ml-4 bg-green-500 px-2 py-1 rounded text-white cursor-pointer" v-if="can.edit"  @click="edit(invoice.id)">
                                            Edit
                                        </BreezeButton>
                                        <BreezeButton class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer" v-if="can.delete"  @click="destroy(invoice.id)">
                                            Delete
                                        </BreezeButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
