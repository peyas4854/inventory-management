<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex bd-highlight mb-3">
                            <h2> Invoice  List </h2>
                            <router-link :to="{ name:'invoiceCreate'}" class="btn btn-primary ms-auto">New Create
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index"
}
</script>

