<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex bd-highlight mb-3">
                                <h2> New Purchase </h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label d-block">Date <span
                                            class="text-danger">*</span></label>
                                        <date-picker v-model:value="invoiceForm.date"
                                                     placeholder="Pick a date"></date-picker>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label">Invoice No <span
                                            class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="invoiceForm.invoice_no"
                                               aria-describedby="emailHelp">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label">Supplier</label>
                                        <select name="" id="" class="form-control"
                                                v-model="invoiceForm.supplier_id">
                                            <option> Please select</option>
                                            <option value="1"> Supplier 1</option>
                                            <option value="2"> Supplier 2</option>
                                            <option value="3"> Supplier 3</option>
                                        </select>

                                    </div>

                                    <div class="col-md-12 mb-3" v-if="products">
                                        <label for="name" class="form-label">Product</label>
                                        <v-select :options="products"
                                                  :reduce="(option) => option.id"
                                                  label="name"
                                                  @option:selected="addProduct"
                                        ></v-select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">SN</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Total Price</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <template v-if="invoiceItem.length">
                                                <tr v-for="(product,index) in invoiceItem">
                                                    <th>{{ index + 1 }}</th>
                                                    <td>
                                                        <input type="text" class="form-control" v-model="product.name">
                                                        <input type="hidden" v-model="product.id">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" readonly
                                                               v-model="product.in_stock">
                                                    </td>
                                                    <td>
                                                        <div class="input-group mb-3">
                                                            <input type="text" class="form-control"
                                                                   aria-label="Recipient's username"
                                                                   aria-describedby="basic-addon2"
                                                                   v-model="product.quantity"
                                                                   @change="changeQuantity(product,index)"
                                                            >
                                                            <span class="input-group-text"
                                                                  id="basic-addon2">Piece</span>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                               v-model="product.price">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" readonly
                                                               v-model="product.total_price">
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger btn-sm cursor-pointer">
                                                            <i class="fa-solid fa-circle-xmark"></i></a>
                                                    </td>
                                                </tr>
                                            </template>
                                            <template v-else>
                                                <tr>
                                                    <td colspan="7" class="text-center">Please Select Product</td>
                                                </tr>

                                            </template>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="name" class="form-label">Note</label>
                                        <input type="text" class="form-control" v-model="invoiceForm.note"
                                               aria-describedby="emailHelp">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label">Total</label>
                                        <input type="text" class="form-control" readonly
                                               v-model="invoiceForm.sub_total">
                                    </div>
                                    <hr>
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary" @click="storeInvoice"> Confirm</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import VueSelect from "vue-select";
import 'vue-select/dist/vue-select.css';
import ApiService from "@/service/api.service";
import CommonMethod from "@/mixin/CommonMethod";
import SweetAlert from "@/service/sweetalert";
import sweetalert from "@/service/sweetalert";

export default {
    name: "create",
    components: {
        DatePicker,
        'v-select': VueSelect,
    },
    mixins: [CommonMethod],
    data() {
        return {
            products: [],
            invoiceItem: [],
            invoiceForm: {},
        }
    },
    mounted() {
        this.allProducts();
    },
    methods: {
        allProducts() {
            ApiService.get('/get/product').then((response) => {
                this.products = response.data.data;
            }).catch((error) => {
                console.log('error', error)
            });
        },
        addProduct(selectedValue) {
            if (selectedValue.in_stock == 0) {
                SweetAlert.error(`${selectedValue.name} is out of stock , please try again`);
            } else {
                this.initialSampleObject(selectedValue);
            }
            this.invoiceForm.sub_total = this.subTotal();
        },
        initialSampleObject(product) {
            let sampleItem = {
                product_id: product.id,
                name: product.name,
                quantity: 1,
                price: product.price,
                in_stock: product.in_stock,
                total_price: product.price * 1
            }
            let newItem = [];
            for (let i = 0; i < 1; i++) {
                newItem.push(Object.assign({}, sampleItem))
            }
            let find = this.invoiceItem.find((e) => {
                return e.product_id == product.id;
            });
            let index = this.invoiceItem.findIndex(e => e.product_id === product.id);
            if (find) {
                this.setQuantityTotalPrice(product, index, true);
            } else {
                this.invoiceItem = this.invoiceItem.concat(newItem);
            }
        },
        changeQuantity(product, index) {
            if (product.quantity > product.in_stock) {
                SweetAlert.error(`Purchase is out of stock , please try again`);
                this.invoiceItem[index].quantity = 1;
                this.invoiceItem[index].total_price = this.numberFormat(product.price);
                return;
            }
            this.setQuantityTotalPrice(product, index);
        },
        setQuantityTotalPrice(product, index, productFound = false) {
            // product duplicate increase quantity
            if (productFound) {
                let quantity = this.invoiceItem[index].quantity + 1;
                this.invoiceItem[index].quantity = quantity;
                this.invoiceItem[index].total_price = quantity * product.price;
            } else {
                // set price and quantity
                this.invoiceItem[index].quantity = product.quantity;
                this.invoiceItem[index].total_price = product.quantity * product.price;
            }
            this.invoiceForm.sub_total = this.subTotal();
        },
        subTotal() {
            let total = this.invoiceItem.map(e => e.total_price).reduce((prev, next) => prev + next);
            return isNaN(total) == true ? 0 : this.numberFormat(total);
        },
        storeInvoice() {
            let formData = new FormData();
            if (this.invoiceForm.date) {
                this.invoiceForm.date = new Date(this.invoiceForm.date).toISOString();
            }

            for (let key in this.invoiceForm) {
                formData.append(key, this.invoiceForm[key]);
            }
            formData.append('itemData', JSON.stringify(this.invoiceItem));
            console.log('invoiceForm', this.invoiceForm);
            ApiService.post('/invoice', formData)
                .then((response) => {
                    sweetalert.success(response.data.message);
                    this.$router.push({name: "invoice"});
                }).catch((error) => {
                console.log('error', error)
            });


        }

    }
}
</script>

