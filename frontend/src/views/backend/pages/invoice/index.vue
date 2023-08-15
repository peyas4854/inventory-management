<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex bd-highlight mb-3">
                            <h2> Invoice  List </h2>
                            <router-link :to="{ name:'invoiceCreate'}" class="btn btn-primary ms-auto">Create new
                            </router-link>
                        </div>
                    </div>
                    <div id="loader" v-if="loader">
                        <loader/>
                    </div>
                    <div class="card-body" v-else>
                        <div class="from-group d-flex flex-row-reverse">
                            <button type="button" class="btn btn-success" @click="getInvoices()">Search</button>
                            <input type="text" class="search form-control" id="search-box" placeholder="Search"
                                   v-model="form.search">

                        </div>
                        <table class="table table-striped product-table">
                            <thead>
                            <tr>
                                <th scope="col">Sl <i class="fad fa-laugh-wink"></i></th>
                                <th scope="col">Date</th>
                                <th scope="col">Invoice No</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Sub Total</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="invoices.length">
                                <tr v-for="(invoice,index) in invoices " :key="index">
                                    <th scope="row"> {{ ++index }}</th>
                                    <td>{{ invoice.date }}</td>
                                    <td>{{ invoice.invoice_no }}</td>
                                    <td>{{ invoice.supplier }}</td>
                                    <td>{{ invoice.sub_total }}</td>

                                    <td>
                                        <div class="d-grid gap-2 d-md-block">

                                            <button class="btn btn-info" type="button" >
                                                View
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="6" class="text-center fs-2">
                                        No data Found!
                                    </td>
                                </tr>
                            </template>

                            </tbody>
                        </table>
                        <div>
                            <pagination v-if="invoices.length > 0" :pagination="pagination"
                                        @paginate="getInvoices()" @callParentMethod="getInvoices" :offset="5"/>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ApiService from '@/service/api.service';
import pagination from '@/components/Pagination';
import SweetAlert from "@/service/sweetalert";
export default {
    name: "index",
    data() {
        return {
            invoices: [],
            pagination: {
                current_page: 1,
            },
            form: {
                per_page: 10,
                search: '',
            },
            loader: false,

        }
    },
    components: {
        pagination,
    },
    mounted() {
        this.getInvoices();
    },
    methods:{
        getInvoices() {
            this.loader = true;
            let params = {
                ...this.form,
                page: this.pagination.current_page
            }
            ApiService.get('/invoice', {params: params}).then((response) => {
                console.log('response',response.data)
                this.invoices = response.data.data;
                console.log('invoices',this.invoices);
                this.pagination = response.data.meta;
                this.loader = false;
            }).catch((error) => {
                console.log('error', error)
            });
        },
    }
}
</script>

