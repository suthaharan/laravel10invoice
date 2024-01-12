import { createRouter, createWebHistory } from "vue-router";
import invoiceIndex from '../components/invoices/index.vue'
import notFound from '../components/NotFound.vue'
import invoiceNew from '../components/invoices/new.vue'
import invoiceShow from '../components/invoices/show.vue'
import invoiceEdit from '../components/invoices/edit.vue'

const routes = [
    {
        path: '/invoice/list',
        component: invoiceIndex
    },{
        path: '/invoice/new',
        component: invoiceNew
    },
    {
        path: '/invoice/show/:id',
        component: invoiceShow,
        props: true
    },
    {
        path: '/invoice/edit/:id',
        component: invoiceEdit,
        props: true
    },
    {
        path: 'invoice/:pathMatch(.*)*',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})


export default router
